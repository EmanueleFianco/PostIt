<?php
/**
 * @package Utility
 * @author Emanuele Fianco
 * @author Fabio Di Sabatino
 * @author Gioele Cicchini
 * @author Federica Caruso
 */
class USingleton
{
   /**
   * La variabile statica privata che conterrà l'istanza univoca
   * della nostra classe.
   */
   private static $instances = array();

   /**
   * Il costruttore in cui ci occuperemo di inizializzare la nostra
   * classe. E' opportuno specificarlo come privato in modo che venga
   * visualizzato automaticamente un errore dall'interprete se si cerca
   * di istanziare la classe direttamente.
   */
   protected function __construct()
   {
      // vuoto
   }

   /**
   * Il metodo statico che si occupa di restituire l'istanza univoca della classe.
   */
   public static function getInstance($c)
   {
        if( ! isset( self::$instances[$c] ) )
        {
            self::$instances[$c] = new $c;
        }
        return self::$instances[$c];
   }
}
?>
