<?php
namespace App\Http\Controllers;

use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SimpananController extends Controller
{
    public function __construct()
    {
        // Constructor can remain empty
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get all simpanan records for this user
        $simpanans = Simpanan::where('user_id', $user->id)
                    ->orderBy('tanggal', 'desc')
                    ->get();
        
        // Calculate total simpanan
        $totalSimpanan = Simpanan::where('user_id', $user->id)
                        ->sum('jumlah');
        
        // Get the earliest simpanan date
        $tanggalBuka = $simpanans->min('tanggal');
        
        // Check if user has paid this month's wajib
        $currentMonthWajib = $this->checkCurrentMonthWajib($user->id);
        
        return view('dashboard.simpanan', compact(
            'user', 
            'totalSimpanan', 
            'simpanans',
            'tanggalBuka',
            'currentMonthWajib'
        ));
    }
    
    public function create(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'pokok');
        
        // If type is wajib, check if payment already made this month
        if ($type === 'wajib') {
            $currentMonthWajib = $this->checkCurrentMonthWajib($user->id);
            
            if ($currentMonthWajib) {
                return redirect()->route('dashboard.simpanan')
                    ->with('info', 'Anda sudah membayar simpanan wajib untuk bulan ini.');
            }
        }
        
        // Get total savings
        $totalSimpanan = Simpanan::where('user_id', $user->id)
                         ->sum('jumlah');
        
        return view('dashboard.create-simpanan', [
            'type' => $type,
            'user' => $user,
            'totalSimpanan' => $totalSimpanan
        ]);
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // If type is wajib, verify again that it's not paid yet
        if ($request->jenis_simpanan === 'wajib') {
            $currentMonthWajib = $this->checkCurrentMonthWajib($user->id);
            
            if ($currentMonthWajib) {
                return redirect()->route('dashboard.simpanan')
                    ->with('info', 'Anda sudah membayar simpanan wajib untuk bulan ini.');
            }
        }
        
        // Handle the form input from number format to database format
        $jumlah = $request->jumlah;
        if (is_string($jumlah)) {
            $jumlah = str_replace('.', '', $jumlah); // Remove thousand separators
            $jumlah = str_replace(',', '.', $jumlah); // Replace comma with dot for decimal
        }

        $request->validate([
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required',
            'keterangan' => 'nullable|string'
        ]);
        
        $paymentMethod = $request->payment_method ?? 'transfer';
        $currentMonth = Carbon::now()->format('F Y');
        
        // Create the savings record in simpanans table
        $simpanan = Simpanan::create([
            'user_id' => $user->id,
            'jenis_simpanan' => $request->jenis_simpanan,
            'jumlah' => $jumlah,
            'tanggal' => now(),
            'keterangan' => $request->jenis_simpanan === 'wajib' 
                ? "Simpanan Wajib $currentMonth via " . ucfirst($paymentMethod) 
                : ($request->keterangan ? $request->keterangan : "Setoran " . ucfirst($request->jenis_simpanan)) . 
                  " via " . ucfirst($paymentMethod)
        ]);
        
        return redirect()->route('dashboard.simpanan.create')
                        ->with('success', 'Simpanan berhasil dibuat');
    }
    
    /**
     * Check if user has already paid the wajib simpanan for current month
     */
    private function checkCurrentMonthWajib($userId) 
    {
        $now = Carbon::now();
        
        return Simpanan::where('user_id', $userId)
                ->where('jenis_simpanan', 'wajib')
                ->whereYear('tanggal', $now->year)
                ->whereMonth('tanggal', $now->month)
                ->first();
    }
}