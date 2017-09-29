//Committee AJAX functions
$('button').on('click tap', function (e) {
    console.log('<a href="' + $(this).data("value1") + '"></a>');

    switch ($(this).data("value0")) {
        //Approve
        case 0:
            if (confirm('Are you sure you want to approve this member?')) {
                $.ajax({
                    url: "/inc/formProcessor.php",
                    type: "POST",
                    data: {
                        approve:'1',
                        userID: $(this).data("value1")
                    },
                    dataType: 'text',
                    async:true,
                    success: function () {
                        location.reload();
                    }
                })
            }
            break;
        //Accredit
        case 1:
            if (confirm('Are you sure you want to accredit this member?')) {
                $.ajax({
                    url: "/inc/formProcessor.php",
                    type: "POST",
                    data: {
                        accreditUser:'1',
                        userID: $(this).data("value1")
                    },
                    dataType: 'text',
                    async:true,
                    success: function () {
                        location.reload();
                    }
                })
            }
            break;
        //Ban
        case 2:
            if (confirm('Are you sure you want to remove the ban from this member?')) {
                $.ajax({
                    url: "/inc/formProcessor.php",
                    type: "POST",
                    data: {
                        banUser:'1',
                        userID: $(this).data("value1")
                    },
                    dataType: 'text',
                    async:true,
                    success: function () {
                        location.reload();
                    }
                })
            }
            break;
    }

});