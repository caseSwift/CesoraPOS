<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@extends('layouts.app')

@section('content')


    <div class="container">
        <h1>Inventory</h1>

        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>

                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($inventoryItems as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>

                            <td>

                                <a href="#" class="edit-btn" data-target="#editModal{{ $item->id }}">Edit</a>
                                <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="article_id">Article</label>
                        <select name="article_id" class="form-control" required>
                            <option value="">Select an article</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->article_id }}">{{ $article->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="0" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>
                <!-- Edit Item Modal -->
                @foreach ($inventoryItems as $item)
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $item->id }}Label" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModal{{ $item->id }}Label">Edit Item</h5>
{{--                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                        <span aria-hidden="true">&times;</span>--}}
{{--                                    </button>--}}
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('inventory.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
{{--                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

<script>
    $(document).ready(function() {

        // Edit item modal
        $('.edit-btn').on('click', function() {
            // Reset the form inputs and clear any previous error messages
            $('#editModal input[name="quantity"]').val('');
            $('#editModal .invalid-feedback').remove();
            // Get the ID of the inventory item being edited
            var inventoryId = $(this).data('target').replace('#editModal', '');

            // Set the form action URL to the correct route for the inventory item
            $('#editModal form').attr('action', '/inventory/' + inventoryId);

            // Show the modal
            $('#editModal' + inventoryId).modal('show');
        });

        $('#editModal form').on('submit', function(event) {
            event.preventDefault();

            // Submit the form via AJAX
            $.ajax({
                url: $(this).attr('action'),
                method: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    // Close the modal and refresh the page
                    $('#editModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    // Display any validation errors
                    var errors = xhr.responseJSON.errors;
                    for (var key in errors) {
                        var message = errors[key][0];
                        var input = $('#editModal input[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + message + '</div>');
                    }
                }
            });
        });
    });
</script>
