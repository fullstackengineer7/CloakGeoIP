<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class SocketController extends Controller implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
       $this->clients->attach($conn);
        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $queryarray);

        if(isset($queryarray['token']))
        {
            User::where('token', $queryarray['token'])->update([ 'connection_id' => $conn->resourceId]);
            $conn->send("socket connection reply from server");
        }
    }

    public function onMessage(ConnectionInterface $conn, $msg){
        $conn->send($msg->data);
    }

    public function onClose(ConnectionInterface $conn){
        $this->clients->detach($conn);
        $querystring = $conn->httpRequest->getUri()->getQuery();
        parse_str($querystring, $queryarray);
        if(isset($queryarray['token']))
        {
            User::where('token', $queryarray['token'])->update([ 'connection_id' => 0]);
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
        echo "A scoket communiation(andr) error has occurred: {$e->getMessage()} \n";
        $conn->close();
    }

}
