<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class DataCustomerController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }
    
    public function index()
    {
        $this->checkAdmin();
        $customers = Customer::orderBy('created_at', 'desc')->get();
        return view('admin.customers.index', compact('customers'));
    }
    
    public function create()
    {
        $this->checkAdmin();
        return view('admin.customers.create');
    }
    
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'nama_perusahaan' => 'required|string|max:100',
            'alamat' => 'required|string',
            'nomor_kontak' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'pic' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);
        
        Customer::create($request->all());
        
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $this->checkAdmin();
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }
    
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        
        $customer = Customer::findOrFail($id);
        
        $request->validate([
            'nama_perusahaan' => 'required|string|max:100',
            'alamat' => 'required|string',
            'nomor_kontak' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'pic' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string',
        ]);
        
        $customer->update($request->all());
        
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $this->checkAdmin();
        $customer = Customer::findOrFail($id);
        $customer->delete();
        
        return redirect()->route('admin.customers.index')
                         ->with('success', 'Customer berhasil dihapus');
    }
    
    public function show($id)
    {
        $this->checkAdmin();
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }
}