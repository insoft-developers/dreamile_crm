<div wire:poll.2s>
    <table class="table table-stripped">
        <tr>
            <thead>
                <th>Lead</th>
                <th>Total</th>
                
            </thead>
            <tbody>

                <tr>
                    <td>
                    <span class="text-success">
                        <i class="bi bi-circle-fill fs-10"></i>
                        <strong>New Lead</strong>
                    </span>
                    </td>
                    <td>{{ $data['new-lead'] ?? 0; }}</td>
                    
                </tr>
                <tr>
                    <td>
                    <span class="text-warning">
                        <i class="bi bi-circle-fill fs-10"></i>
                        <strong>Visit</strong>
                    </span>
                    </td>
                    <td>{{ $data['visit'] ?? 0; }}</td>
                    
                </tr>
                <tr>
                    <td>
                    <span class="text-prmary">
                        <i class="bi bi-circle-fill fs-10"></i>
                        <strong>Confirmation</strong>
                    </span>
                    </td>
                    <td>{{ $data['confirm'] ?? 0; }}</td>
                    
                </tr>
                <tr>
                    <td>
                    <span class="text-info">
                        <i class="bi bi-circle-fill fs-10"></i>
                        <strong>Deal</strong>
                    </span>
                    </td>
                    <td>{{ $data['deal'] ?? 0; }}</td>
                    
                </tr>
                <tr>
                    <td>
                    <span class="text-danger">
                        <i class="bi bi-circle-fill fs-10"></i>
                        <strong>NOK</strong>
                    </span>
                    </td>
                    <td>{{ $data['nok'] ?? 0; }}</td>
                    
                </tr>

            </tbody>
        </tr>
    </table>
</div>
