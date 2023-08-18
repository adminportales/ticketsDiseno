<div wire:poll.5s>
    <div class="row">
        @foreach ($designersAssigments as $designerByType)
            <div class="col-md-4 shadow">
                <strong>{{ $designerByType['type'] }}</strong><br>
                <br>
                @if (array_key_exists('designers', $designerByType['designer']))
                    <strong>Diseñadores Contemplados</strong>
                    <br>
                    @foreach ($designerByType['designers'] as $designer)
                        {{ $designer['name'] }}
                        <br>
                    @endforeach
                    <br>
                @endif

                @if (array_key_exists('data', $designerByType['designer']))
                    <strong>Ticket Abiertos</strong>
                    <br>
                    @foreach ($designerByType['designer']['data'] as $itemDesigner)
                        {{ $itemDesigner['designer']->name }}
                        {{ $itemDesigner['total'] }}
                        <br>
                    @endforeach
                    <br>
                @endif

                @if (array_key_exists('newData', $designerByType['designer']))
                    <strong>Misma Cantidad de Tickets</strong>
                    <br>
                    @foreach ($designerByType['designer']['newData'] as $itemDesigner)
                        {{ $itemDesigner['designer']->name }}
                        {{ $itemDesigner['total'] }}
                        <br>
                    @endforeach
                    <br>
                @endif
                @if (array_key_exists('lastestTicket', $designerByType['designer']))
                    <strong>Tickets Abiertos</strong>
                    <br>
                    @foreach ($designerByType['designer']['lastestTicket'] as $ticket)
                        {{ $ticket->designerTicket->name }}
                        {{ $ticket->latestTicketInformation->title }}
                        {{ $ticket->latestStatusChangeTicket->status }}
                        {{ $ticket->updated_at->format('H:i:s d/m/Y') }}
                        <br>
                    @endforeach
                    <br>
                @endif
                <strong>Diseñador Asignado al Siguiente Ticket</strong>
                <br>
                <p>{{ $designerByType['designer']['designer']->name }}</p>
                <strong>{{ $designerByType['designer']['msg'] }}</strong>
                <hr>
            </div>
        @endforeach
    </div>
</div>
