$(document).ready(function () {

    $('#employeetable').DataTable();

    $('#search_date_of_joining').datetimepicker({
        format: 'L'
    });

    
    //fetch_employee_data();

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
            console.log(data.positions);
            // $("#positiontable > tbody").empty();
            // var i = 0;
            // for (i; i < data.positions.length; i++) {
            //     console.log(data.positions[i].name);
            //     var content = "";
            //     var department;
            //     var j = 0;
            //     for (j;j<data.departments.length; j++) {
            //         if (data.positions[i].dept_id == data.departments[j].id) {
            //             department = data.departments[j];
            //             break;
            //         }
            //     }
            //     console.log(department.name);
            //     content = '<tr><td>'+ data.positions[i].name +'</td><td>'+ department.name +'</td><td><div class="row"><div class="col-md-1" style="margin-right: 40px"><form action="/admin/sys_mgnt/position/'+ data.positions[i].id +'/edit" method="get"><input type="submit" class="btn btn-warning" value="Edit"></form></div><div class="col-md-1"><button class="btn btn-danger" onclick="delete_position('+ data.positions[i].id +')">Delete</button></div></div></td></tr>';    
            //     $("#positiontable > tbody").append(content);
            // }
        }
    })
}

function delete_position(id) {
    //console.log("delete user "+id);
    if (confirm('Are you sure you want to DELETE ?')) {
        $.ajax({
            url: "/admin/sys_mgnt/position/" + id,
            method: 'DELETE',
            data: { _token: token, id: id },
            dataType: 'json',
            success: function (data) {
                location.reload();
                // location.replace("/admin/user_mgnt");
            }
        });
        //location.reload();
        fetch_employee_data();
        //location.replace("/admin/user_mgnt");
    }
}