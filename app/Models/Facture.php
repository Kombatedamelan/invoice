<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    /**
     * Le nom de la table associée au modèle.
     *
     * @var string
     */
    protected $table = 'factures';

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'invoice_number',
        'client',
        'order_number',
        'object',
        'lines',
        'total_amount',
        'amount_in_words',
        'status',
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'date',
        'lines' => 'array',
        'total_amount' => 'decimal:0',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * Accesseur pour le montant total formaté
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', ' ') . ' FCFA';
    }

    /**
     * Accesseur pour la date formatée
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d/m/Y');
    }

    /**
     * Accesseur pour l'objet tronqué (pour les aperçus)
     */
    public function getShortObjectAttribute(): string
    {
        return strlen($this->object) > 50 ? substr($this->object, 0, 50) . '...' : $this->object;
    }

    /**
     * Scope pour les factures payées
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'payée');
    }

    /**
     * Scope pour les factures en attente
     */
    public function scopePending($query)
    {
        return $query->where('status', 'en attente');
    }

    /**
     * Scope pour les factures en retard
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'en retard');
    }

    /**
     * Vérifier si la facture est payée
     */
    public function isPaid(): bool
    {
        return $this->status === 'payée';
    }

    /**
     * Vérifier si la facture est en attente
     */
    public function isPending(): bool
    {
        return $this->status === 'en attente';
    }

    /**
     * Générer le prochain numéro de facture
     */
  public static function generateInvoiceNumber(): string
    {
        $month = date('m');
        $year = date('Y');

        $lastFacture = self::where('invoice_number', 'LIKE', "%/{$month}/MOU/{$year}")
            ->orderByDesc('id')
            ->first();

        // Numéro de départ (dernière facture papier)
        $startNumber = 125;

        if ($lastFacture) {
            preg_match('/^(\d{3})/', $lastFacture->invoice_number, $matches);
            $nextNumber = (int) $matches[1] + 1;
        } else {
            $nextNumber = $startNumber + 1;
        }

        return sprintf('%03d/%02d/MOU/%04d', $nextNumber, $month, $year);
    }
    /**
     * Convertir un nombre en lettres
     * 
     * @param int|float $number Le nombre à convertir
     * @return string Le nombre en lettres
     */
    public static function numberToWords($number): string
    {
        // Convertir en int pour éviter les erreurs de type
        $number = (int) $number;
        
        if ($number === 0) return 'Zéro';
        
        $units = ['', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf'];
        $tens = ['', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingt', 'quatre-vingt-dix'];
        
        $convertHundreds = function($num) use ($units, $tens) {
            $result = '';
            $hundred = intdiv($num, 100);
            $remainder = $num % 100;
            
            if ($hundred > 0) {
                if ($hundred === 1) $result .= 'cent ';
                else $result .= $units[$hundred] . ' cents ';
            }
            
            if ($remainder > 0) {
                if ($remainder < 17) {
                    $result .= $units[$remainder];
                } elseif ($remainder < 20) {
                    $result .= 'dix-' . $units[$remainder - 10];
                } elseif ($remainder < 70) {
                    $tensIndex = intdiv($remainder, 10);
                    $unit = $remainder % 10;
                    $result .= $tens[$tensIndex];
                    if ($unit > 0) {
                        if ($tensIndex === 7 || $tensIndex === 9) $result .= '-';
                        else $result .= '-';
                        $result .= $units[$unit];
                    }
                    if ($unit === 1 && $tensIndex !== 8) $result .= ' et un';
                } elseif ($remainder < 80) {
                    $result .= 'soixante';
                    $unit = $remainder - 60;
                    if ($unit > 0) {
                        $result .= '-';
                        if ($unit === 1) $result .= 'et un';
                        else $result .= $units[$unit];
                    }
                } elseif ($remainder < 90) {
                    $result .= 'quatre-vingt';
                    $unit = $remainder - 80;
                    if ($unit > 0) {
                        $result .= '-';
                        if ($unit === 1) $result .= 'un';
                        else $result .= $units[$unit];
                    }
                } else {
                    $result .= 'quatre-vingt-dix';
                    $unit = $remainder - 90;
                    if ($unit > 0) {
                        $result .= '-';
                        if ($unit === 1) $result .= 'un';
                        else $result .= $units[$unit];
                    }
                }
            }
            return trim($result);
        };
        
        if ($number < 1000000) {
            $thousands = intdiv($number, 1000);
            $remainder = $number % 1000;
            $result = '';
            
            if ($thousands > 0) {
                if ($thousands === 1) $result .= 'mille ';
                else $result .= $convertHundreds($thousands) . ' mille ';
            }
            
            if ($remainder > 0) {
                $result .= $convertHundreds($remainder);
            }
            
            return trim($result);
        }
        
        return (string) $number;
    }

    /**
     * Calculer le montant total à partir des lignes
     * 
     * @param array $lines Les lignes de la facture
     * @return float Le montant total
     */
    public static function calculateTotalFromLines(array $lines): float
    {
        $total = 0;
        foreach ($lines as $line) {
            $quantity = self::parseQuantity($line['quantity'] ?? 0);
            $days = (float) ($line['days'] ?? 0);
            $unitPrice = (float) ($line['unit_price'] ?? 0);
            $total += $quantity * $days * $unitPrice;
        }
        return $total;
    }

    /**
     * Parser la quantité (gère les pourcentages)
     * 
     * @param string|int|float $quantity La quantité à parser
     * @return float La quantité parsée
     */
    private static function parseQuantity($quantity): float
    {
        if (is_string($quantity) && str_contains($quantity, '%')) {
            return (float) str_replace('%', '', $quantity) / 100;
        }
        return (float) $quantity;
    }
}