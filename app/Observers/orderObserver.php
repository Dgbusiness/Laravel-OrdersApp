<?php

namespace App\Observers;

use App\Log;
use App\Order;

class orderObserver
{
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $log = new Log();
        $log->command = "Se ha creado una nueva orden. ID: ".$order->id;
        $log->save();
    }
    /**
     * Handle the order "retrieved" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function retrieved(Order $order)
    {
        $log = new Log();
        $log->command = "Se ha recuperado las ordenes del usuario ( ID: ".$order->users()->first()->id.").";
        $log->save();
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        $log = new Log();
        $log->command = "Se ha actualizado una orden. ID: ".$order->id;
        $log->save();
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        $log = new Log();
        $log->command = "Se ha eliminado una orden. ID: ".$order->id;
        $log->save();
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
