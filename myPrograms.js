$(document).ready(function() {
    
    $('#programSelect').change(function() {
        var programId = $(this).val();
        $(".inviteURL").empty();
        $(".inviteURL").html("Invitation Link is: <span>http://localhost/wr/book.php?pid="+programId+"</span>");
        // Use AJAX to fetch and display the guest list and seating arrangements for the selected program
        $.ajax({
            url: 'fetch_guests.php', // The PHP file that retrieves guest data
            type: 'POST',
            data: {programId: programId},
            success: function(response) {
                $('#guestList').prepend(response); 
                $('#updateButton').show();
            }
        });
        
        $('.removeGuest').click(function() {
            $(this).siblings('input[type="text"]').val('');
        });
    });

    


});
