<div style="background-color:#eeeeee; padding:20px 20px; border-radius: 4px; border: 1px solid #a1887f;">
    <div style="margin-top: 10px; background-color:#fff; padding:10px 10px; border-radius: 4px; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);">
        <table width="100%" cellpadding="5">
            <tr>
                <td><strong>Name</strong></td>
                <td>: {{ $name }}</td>
                <td><strong>Email</strong></td>
                <td>: {{ $email }}</td>
                <td><strong>Phone</strong></td>
                <td>: {{ $phone }}</td>
            </tr>

            <tr>
                <td><strong>Description</strong></td>
                <td colspan="5">
                    <p>{{ $description }}</p>
                </td>
            </tr>
        </table>
    </div>
</div>