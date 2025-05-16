<?php

declare(strict_types=1);

namespace App\Events;

use App\Data\Imports\UserImport\ImportedUserRow;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

final class ImportedUserCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public readonly ImportedUserRow $importedUserRow)
    {
    }

    public function broadcastOn(): Channel
    {
        // Для публичного канала можно вернуть new Channel('user-import');
        return new PrivateChannel('user-import');
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->importedUserRow->id,
            'name' => $this->importedUserRow->name,
            'date' => $this->importedUserRow->date->toDateString(),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ImportedUserCreated';
    }
}
