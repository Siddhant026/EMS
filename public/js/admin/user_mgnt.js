$(document).ready(function () {

    $('#usertable').DataTable();

    //console.log("working");
    fetch_user_data();

    $("#search").click(function () {
        var name = $("#search_name").val();
        var email = $("#search_email").val();
        var role = $("#search_role").val();
        fetch_user_data(name, email, role);
    });
});

function fetch_user_data(name = '', email = '', role = '') {
    $.ajax({
        url: "/user_filter",
        method: 'GET',
        data: { name: name, email: email, role: role },
        dataType: 'json',
        success: function (data) {
            $("#usertable > tbody").empty();
            //$("#usertable > tbody").
            //$('#data').html(data.text);
            //$('#data').html(data.users[0].email)
            var i = 0;
            for (i; i < data.users.length; i++) {
                //login_id = " {{ Auth::user()->id }} ";
                //console.log(login_id);
                var content = "";
                var actions = "";
                if (data.users[i].id == login_id) {
                    actions = '<form action="/admin/user_mgnt/' + data.users[i].id + '/edit" method="get"><input type="submit" class="btn btn-warning" value="Edit"></form>';
                } else {
                    actions = '<div class="row"><div class="col-md-2"><form action="/admin/user_mgnt/' + data.users[i].id + '/edit" method="get"><input type="submit" class="btn btn-warning" value="Edit"></form></div><div class="col-md-1"><button class="btn btn-danger" onclick="delete_user(' + data.users[i].id + ')">Delete</button></div></div>';
                }
                if (data.users[i].role == 0) {
                    content = "<tr><td>" + data.users[i].name + "</td><td>" + data.users[i].email + "</td><td>Admin</td><td>" + actions + "</td></tr>"
                } else {
                    content = "<tr><td>" + data.users[i].name + "</td><td>" + data.users[i].email + "</td><td>Employee</td><td>" + actions + "</td></tr>"
                }
                //$content = "<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>Admin</td></tr>"
                $("#usertable > tbody").append(content);
            }
        }
    })
}

function delete_user(id) {
    //console.log("delete user "+id);
    if (confirm('Are you sure you want to DELETE ?')) {
        $.ajax({
            url: "user_mgnt/"+id,
            method: 'DELETE',
            data: { _token: token, id: id },
            dataType: 'json',
            success: function (data) {
                // location.replace("/admin/user_mgnt");
            }
        });
        fetch_user_data();
        //location.replace("/admin/user_mgnt");
    }
}