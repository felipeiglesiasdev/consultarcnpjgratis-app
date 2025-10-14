<?php // INÍCIO DO ARQUIVO PHP

namespace App\Models; // NAMESPACE DO MODEL

use Illuminate\Database\Eloquent\Model; // CLASSE BASE DO ELOQUENT
use Illuminate\Database\Eloquent\Relations\HasMany; // TIPO DE RELACIONAMENTO

class Cnae extends Model // DEFINIÇÃO DA CLASSE CNAE
{
    protected $connection = 'mysql_dados';
    protected $table = 'cnaes'; // NOME DA TABELA
    protected $primaryKey = 'codigo'; // CHAVE PRIMÁRIA
    public $incrementing = false; // CHAVE PRIMÁRIA NÃO É AUTOINCREMENTAL
    public $timestamps = false; // DESATIVA TIMESTAMPS

    protected $fillable = [ // ATRIBUTOS PREENCHÍVEIS
        'codigo', // COLUNA
        'descricao', // COLUNA
    ]; // FIM DO ARRAY

    // RELACIONAMENTO 1-N
    public function estabelecimentos(): HasMany
    {
        return $this->hasMany(Estabelecimento::class, 'cnae_fiscal_principal', 'codigo'); // RETORNA O RELACIONAMENTO
    }

    public function getCodigoFormatadoAttribute(): string
    {
        $codigo = str_pad($this->codigo, 7, '0', STR_PAD_LEFT); // Garante que o código tenha 7 dígitos
        
        // Formata para o padrão visual
        return sprintf('%s.%s-%s/%s',
            substr($codigo, 0, 2), // Seção
            substr($codigo, 2, 2), // Divisão
            substr($codigo, 4, 1), // Grupo
            substr($codigo, 5, 2)  // Classe
        );
    }
}