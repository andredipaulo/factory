<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'ddd',
        'phone',
        'street_name',
        'address',
        'complement',
        'neighborhood',
        'city',
        'state',
        'limit',
        'postcode',
        'status',
        'observation',
    ];

    public function getClients(string $search = "")
    {
        $clients = $this->where( function ($query) use ($search) {
            if ($search){
                #first_name
                $query->where('first_name', $search);
                $query->orWhere('first_name', 'LIKE', "%{$search}%");
                #last_name
                $query->orWhere('last_name', $search);
                $query->orWhere('last_name', 'LIKE', "%{$search}%");
                #email
                $query->orWhere('email', $search);
                $query->orWhere('email', 'LIKE', "%{$search}%");
                #phone
                $query->orWhere('phone', $search);
                $query->orWhere('phone', 'LIKE', "%{$search}%");
            }
        })->get();
        //->paginate(10);
        return $clients;

    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class, 'client_id', 'id');
    }

    public function getTotalClients()
    {
        $clients = Client::where('status', 'Ativo')
            ->get();

        return count($clients);
    }
    public function getTotalClientsArrears()
    {

        $sql = "SELECT
                 c.id,
                 c.first_name,
                 c.last_name ,
                 l.loan_date ,
                 l.amount
                FROM clients c
                INNER JOIN loans l ON c.id = l.client_id
                LEFT JOIN payments p ON l.id = p.loan_id
                WHERE l.status = 'Aberto'
                GROUP BY c.id,
                         c.first_name,
                         c.last_name ,
                         l.loan_date ,
                         l.amount
                HAVING ( DATEDIFF(CURDATE(), l.loan_date) > 30 ) AND
 ( DATEDIFF(CURDATE(), MAX(p.payment_date)) > 30  or DATEDIFF(CURDATE(), MAX(p.payment_date)) is null )
                ";

        $clients = DB::select($sql);

        return count($clients);
    }
}
