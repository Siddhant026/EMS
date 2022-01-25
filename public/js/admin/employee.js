$(document).ready(function () {

    $('#employeetable').DataTable();

    $('#search_date_of_joining').datetimepicker({
        format: 'L'
    });

    
    fetch_employee_data();

    $("#search").click(function () {
        var name = $("#search_name").val();
        var dept_id = $("#search_dept_id").val();
        var pincode = $("#search_pincode").val();
        var date_of_joining = $("#search_date_of_joining").val();
        //console.log(dept_id);
        fetch_employee_data(name, dept_id, pincode, date_of_joining);
    });
});

function fetch_employee_data(name = '', dept_id = '', pincode = '', date_of_joining = '') {
    $.ajax({
        url: "/employee_filter",
        method: 'GET',
        data: { name: name, dept_id: dept_id, pincode: pincode, date_of_joining: date_of_joining },
        dataType: 'json',
        success: function (data) {
            // console.log(data.positions);
            $("#employeetable > tbody").empty();
            var i = 0;
            for (i; i < data.employees.length; i++) {
                if (data.employees[i].role == employee_role) {
                    var role = "Employee";
                } else {
                    var role = "Manager"
                }
                var content = "";
                content = '<tr><td>'+ data.employees[i].uname +'</td><td>'+ data.employees[i].dob +'</td><td>'+ data.employees[i].address +'</td><td>'+ data.employees[i].pincode +'</td><td>'+ data.employees[i].email +'</td><td>'+ data.employees[i].date_of_joining +'</td><td>'+ data.employees[i].pname +'</td><td>'+ data.employees[i].dname +'</td><td>'+ role +'</td><td><form action="/admin/emp_mgnt/employee/'+ data.employees[i].id +'/edit" method="get"><input type="submit" class="btn btn-warning" value="Edit"></form><br><button class="btn btn-danger" onclick="delete_employee('+ data.employees[i].id +')">Delete</button></td></tr>';    
                $("#employeetable > tbody").append(content);
            }
        }
    })
}

function delete_employee(id) {
    //console.log("delete user "+id);
    if (confirm('Are you sure you want to DELETE ?')) {
        $.ajax({
            url: "/admin/emp_mgnt/employee/" + id,
            method: 'DELETE',
            data: { _token: token, id: id },
            dataType: 'json',
            success: function (data) {
                //location.reload();
                // location.replace("/admin/user_mgnt");
            }
        });
        //location.reload();
        fetch_employee_data();
        //location.replace("/admin/user_mgnt");
    }
}