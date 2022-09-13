$("document").ready(function () {
    $('#closeModal').click(function () {
        $('#userInfo').modal('hide');
    });

    $("#userDetail").on("submit", function (e) {
        e.preventDefault();
        if ($("#name").val().trim().length !== 0) {
            submitUserName();
        }
    });
});


function submitUserName() {
    $.ajax({
        type: 'POST',
        url: '../php/userInfo.php',
        data: {
            name: $("#name").val(),
            target: $("#target").val()
        },
        success: function (res) {

            let modalClose = document.getElementById('closeModal');
            if (modalClose != null) modalClose.click();

            let flashDiv = document.getElementById("flashMessage");
            if (flashDiv != null) {
                flashDiv.classList.remove("d-none");

                setTimeout(function () {
                    flashDiv.classList.add("d-none");
                }, 1500);
            }

            window.location.href = './draw.php';
        },
        error: function () {
            let element = document.getElementById("flashMessage");
            element.textContent = "Failed to add user";
        }
    });
}











