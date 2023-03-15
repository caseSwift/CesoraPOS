<form method="POST" action="{{ route('table.orders.store', ['id' => $table->id]) }}">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="total">
            Total
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="total" name="total" type="text" placeholder="Enter the total">
    </div>

    <!-- add other form fields as needed -->

    <div class="flex items-center justify-between">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Add Order
        </button>
    </div>
</form>
