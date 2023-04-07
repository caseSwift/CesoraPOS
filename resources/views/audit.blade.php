<style>
table {
border-collapse: collapse;
width: 100%;
}

th, td {
border: 1px solid #ddd;
padding: 8px;
text-align: left;
}

th {
background-color: #f2f2f2;
font-weight: bold;
}

tr:nth-child(even) {
background-color: #f2f2f2;
}
</style>

@vite('C:\Users\veljk\OneDrive\Desktop\cesora1\resources\css\app.css')
{{--Header--}}
<header class="bg-gray-800 text-gray-100 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <a href="{{ route('main') }}"><h1 class="text-2xl font-bold">Restaurant POS</h1></a>

        <nav>
            <ul class="flex space-x-4">
                <li><a href="/main" class="hover:text-gray-300">Menu</a></li>
                <li><a href="#" class="hover:text-gray-300">Orders</a></li>
                <li><a href="#" class="hover:text-gray-300">Settings</a></li>
                @if(auth()->check() && auth()->user()->hasRole('administrator'))
                    <li><a href="#" class="hover:text-gray-300">Administrator</a></li>
                @endif
                <li><a href="#" class="hover:text-gray-300"><form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit">Logout</button>
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
{{--End of Header--}}
<h1>Audit Trail </h1>

<table>
    <thead>
    <tr>
        <th>Date/Time</th>
        <th>User</th>
        <th>Action</th>
        <th>Old Quantity</th>
        <th>New Quantity</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($audits as $audit)
        <tr>
            <td>{{ $audit->created_at }}</td>
            <td>{{ $audit->user->name }}</td>
            <td>{{ $audit->action }}</td>
            <td>{{ $audit->old_quantity }}</td>
            <td>{{ $audit->new_quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="pagination">
    @if ($page > 1)
        <a href="{{ route('audit.index', [ 'page' => $page - 1]) }}">Previous</a>
    @endif

    @if ($audits->count() == $limit)
            <a href="{{ route('audit.index', ['page' => $page + 1]) }}">Next</a>
    @endif
</div>
