
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@vite('C:\Users\veljk\OneDrive\Desktop\cesora1\resources\css\app.css')
<div id="modal" class="modal">
    <div class="modal-content">
        <h2 id="article-name"></h2>
        <form method="post" id="add-to-order-form">
            @csrf
            <input type="hidden" name="article_id">
            <label for="quantity">Name</label>
            <div class="quantity-input">
                <button type="button" id="quantity-minus-btn">-</button>
                <input type="number" name="quantity" id="quantity-input" value="1" min="1" max="100">
                <button type="button" id="quantity-plus-btn">+</button> <p id="article-price"></p>
            </div>
            <button onclick="updateOrderSummary()" type="button" class="add-to-order-btn">Add to Order</button>
            <button type="button"  class="cnc-order-btn" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>
<header class="bg-gray-800 text-gray-100 py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <h1 class="text-2xl font-bold">Restaurant POS</h1>
        <nav>
            <ul class="flex space-x-4">
                <li><a href="#" class="hover:text-gray-300" id="user-earnings-link">User Earnings</a></li>

                <li><a href="#" class="hover:text-gray-300" id="daily-profit-link">Daily profit</a></li>
                <li><a onclick="checkOut()" href="#" class="hover:text-gray-300">Check out</a></li>
                <li><a href="#" class="hover:text-gray-300">Menu</a></li>
                <li><a href="#" class="hover:text-gray-300">Orders</a></li>
                <li><a href="#" class="hover:text-gray-300">Settings</a></li>
                @if(auth()->check() && auth()->user()->hasRole('administrator'))
                    <li><a href="{{ route('administrator') }}" class="hover:text-gray-300">Administrator</a></li>
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

<div class="grid grid-cols-2 grid-rows-2 h-full">
    <div class="bg-gray-100 col-span-1 row-span-1"> {{--Quad 1--}}
        <div id="order-summary" class="text-xl text-sm"></div>

    </div>
{{--    quad 2--}}
    <div class="bg-gray-200 col-span-1 row-span-1">
        <div class="bg-gray-200 col-span-1 row-span-1">
            <h2 class="text-lg font-medium mb-4">Articles</h2>
            <div class="flex space-x-2">
                @foreach($articleTypes as $articleType)
                    <form action="{{ route('table.show', ['id' => request()->route('id')]) }}" method="get">

                    <button type="submit" class="p-2 flex-grow bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">{{ $articleType }}</button>
                        <input type="hidden" name="type" value="{{ $articleType }}">
                    </form>
                @endforeach
            </div>
            <div class="mt-4">
                @if($type)
                    <h3 class="text-md font-medium mb-2">Articles of type {{ $type }}</h3>
                    @foreach($articles as $article)
                        <button type="button"  data-price="{{ $article->price }}"  onclick="return openModal('{{ $article->name }}', {{ $article->price }})" class="bg-orange-500 p-2 flex-grow  hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">{{ $article->name }}</button>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
{{--    end quad2--}}
    <div class="bg-gray-300 col-span-1 row-span-1">3 </div>
    <div class="bg-gray-400 col-span-1 row-span-1">



    </div>
</div>

<script>

    const url = window.location.href;
    let match = url.match(/table\/(\d+)/);
    let tableId = match[1];

    console.log(tableId);
// on load
    function displayActiveOrderItems() {

        // Send an AJAX request to get the active order items for the table
        const options = {
            method: 'POST',
            body: JSON.stringify({ table_id: tableId }),
            headers: {
                'Content-Type': 'application/json'
            }
        };
        fetch(`/orders/get-active-items`, options)
            .then((response) => response.json())
            .then((data) => {console.log(data)
                // Build the summary string with active order items
                let newSummary = '';
                data.forEach(data => {
                    const newItemName = `${data.article_name} #${data.item_number}`;
                    const quantity = data.quantity || 0;
                    const price = data.total_price || 0;

                    const newItemLine = `${newItemName} x${quantity} $${price}\n`;
                    newSummary += newItemLine;
                });

                // Update the order summary section with the new summary
                const orderSummary = document.getElementById('order-summary');
                orderSummary.innerText = newSummary;
            })
            .catch((error) => console.error(error));
    }

    // Get the modal

    // Getting table id

    const modal = document.getElementById('modal');
    const articleName = document.getElementById('article-name');

    // Get the button that opens the modal
    const openModalBtn = document.getElementById('open-modal-btn');

    // Get the <span> element that closes the modal
    const closeBtn = document.getElementsByClassName('close')[0];

    // Get the quantity input field and buttons
    const quantityInput = document.getElementById('quantity-input');

    const plusBtn = document.getElementById('quantity-plus-btn');
    const minusBtn = document.getElementById('quantity-minus-btn');
    const close = document.getElementsByClassName('cnc-order-btn')[0];

    // Function to open the modal
    function openModal(name, price) {
        document.getElementById('article-name').innerText = name;
        document.getElementById('article-price').innerText = `$${price}`;
        modal.style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = 'none';
    }

    function updateOrderSummary() {
        const articleName = document.getElementById('article-name').innerText;
        const quantity = parseInt(document.getElementById('quantity-input').value);
        const price = parseFloat(document.getElementById('article-price').innerText.replace(/[^0-9.-]+/g, ''));
        const formattedPrice = price * quantity;

        const orderSummary = document.getElementById('order-summary');
        const existingSummary = orderSummary.innerText;

        let itemNumber = 1;
        const existingItem = existingSummary.match(new RegExp(`${articleName} #\\d+`, 'g'));
        if (existingItem) {
            const lastItemNumber = parseInt(existingItem[existingItem.length - 1].match(/\d+/));
            itemNumber = lastItemNumber + 1;
        }

        const newItemName = `${articleName} #${itemNumber}`;
        const newItemLine = `${newItemName} x${quantity} $${formattedPrice.toFixed(2)}\n`;
        const newSummary = `${existingSummary}${newItemLine}`;
        orderSummary.innerText = newSummary;

        // Send an AJAX request to check for an active order for this table
        const options = {
            method: 'POST', // or 'PUT', 'PATCH', etc.
            body: JSON.stringify({ table_id: tableId,
            article_name:articleName,
            price:price,
            quantity:quantity,
                item_number:itemNumber
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        };
        fetch(`/orders/check-active`, options)
            .then((response) => response.json())
            .then((data) => console.log(data))
            .catch((error) => console.error(error));
    }

    function checkOut() {
        if (confirm("Are you sure you want to check out?")) {
            // Send an AJAX request to mark the table as checked out

            $.ajax({
                url: '/table/' + tableId + '/checkout',
                type: 'POST',

                success: function(response) {
                    // Reload the page after checkout

                    window.location.reload();
                    if (response.total_price) {
                        alert('Total price: ' + response.total_price);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }
    // Event listeners
    //user earnings
    document.getElementById('user-earnings-link').addEventListener('click', function() {
        // Get the user ID from the current user
        var userId = '{{ Auth::user()->id }}';

        // Call the user earnings route and display the total
        axios.get('/user-earnings/' + userId)
            .then(function(response) {
                var total = response.data.total;
                alert('Your earnings for today: $' + total.toFixed(2));
            })
            .catch(function(error) {
                console.error(error);
            });
    });
    //end of user earnings
    // Daily profit
    document.getElementById('daily-profit-link').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the link from redirecting to another page

        $.ajax({
            url: '/daily-profit',
            type: 'GET',
            success: function(response) {
                alert('Total profit: ' + response.total);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
    // end of daily profit
    close.addEventListener('click', closeModal);
    plusBtn.addEventListener('click', () => increaseQuantity());
    minusBtn.addEventListener('click', () => decreaseQuantity());
    window.addEventListener('load', displayActiveOrderItems);

</script>
