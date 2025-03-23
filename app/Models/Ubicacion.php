<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'language_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function nombre(): Attribute
    {
        return new Attribute(
            set: function($value){
                return mb_strtoupper($value);
            }
        );
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function tours()
    {
        return $this->hasMany('App\Models\Tour')->activos()->orderBy('orden', 'asc');
    }

    public function toursweb()
    {
        return $this->hasMany('App\Models\Tour')->activos()->web();
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function traducciones(){
        return $this->belongsToMany('App\Models\Ubicacion','translate','id_model','id_model_traducido')->wherePivot('table','ubicacions');
    }

    public function traduccionesinversas(){
        return $this->belongsToMany('App\Models\Ubicacion','translate','id_model_traducido','id_model')->wherePivot('table','ubicacions');
    }

    public function traduccion($id)
    {
        $traducir= $this->traducciones->firstWhere('language_id', $id);
        $traducir2=$this->traduccionesinversas->firstWhere('language_id', $id);
        if($traducir){
            return $traducir;
        }
        if($traducir2){
            return $traducir2;
        }
        return $this;
    }
}
