<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Guest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .logoutBtn{
          position: absolute;
          top: 0;
          right: 0;
        }

        .createProgram{
          position: absolute;
          top: 0;
          right: 100px;
        }
    </style>
</head>
<body>
<div class="container mt-5 position-relative">
      <a class="btn btn-secondary createProgram" href='./myPrograms.php'>My Program</a>
      <a class="btn btn-primary logoutBtn" href='./logoutHost.php'>Logout</a>
    <h2>Search for a Guest's Table</h2>
    <form id="searchForm">
        <div class="mb-3">
            <label for="guestName" class="form-label">Guest Name</label>
            <input type="text" class="form-control" id="guestName" name="guestName" placeholder="Enter full or part of the guest name">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <div id="searchResults" class="mt-4"></div>
</div>

<div class="container mt-5">
    <h2>Search for Guests by Table Number</h2>
    <form id="tableSearchForm">
        <div class="mb-3">
            <label for="tableNumber" class="form-label">Table Number</label>
            <input type="number" class="form-control" id="tableNumber" name="tableNumber" placeholder="Enter table number">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <div id="tableSearchResults" class="mt-4"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $("#searchForm").submit(function(event) {
        event.preventDefault();
        var guestName = $("#guestName").val();

        $.ajax({
            url: 'search_guest.php',
            type: 'POST',
            data: { guestName: guestName },
            success: function(response) {
                $("#searchResults").html(response);
            }
        });
    });

    $("#tableSearchForm").submit(function(event) {
        event.preventDefault();
        var tableNumber = $("#tableNumber").val();

        $.ajax({
            url: 'search_table.php',
            type: 'POST',
            data: { tableNumber: tableNumber },
            success: function(response) {
                $("#tableSearchResults").html(response);
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
                $("#tableSearchResults").html("An error occurred while searching. Please try again.");
            }
        });
    });
</script>
</body>
</html>
