<form method="POST" action="{{ route('sales-report-results') }}">
    @csrf
    <div class="form-group">
        <label for="start-date">Start Date:</label>
        <input type="date" id="start-date" name="start_date" class="form-control">
    </div>
    <div class="form-group">
        <label for="end-date">End Date:</label>
        <input type="date" id="end-date" name="end_date" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">View Report</button>
</form>
