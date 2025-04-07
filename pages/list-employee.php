<?php
    global $wpdb;

    $employees =  $wpdb -> get_results("SELECT * FROM {$wpdb->prefix}ems_form_data ");
?>

<div class="row mt-4">
    <div class="col-lg-10">
        <div class="border rounded">
            <h4 class="bg-dark text-light px-3 py-2 rounded">
                List Employee
            </h4>

            <div class="ems-table-wrapper px-3 pb-4">
                <table class="table" id="ems-list-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($employees) > 0 ){
                            foreach($employees as $data){  ?>    
                                <tr>
                                    <td> <?php echo $data -> id ?> </td>
                                    <td> <?php echo $data -> name ?> </td>
                                    <td> <?php echo $data -> email ?> </td>
                                    <td> <?php echo $data -> gender ?> </td>
                                    <td> <?php echo $data -> designation ?> </td>
                                    <td>
                                        <a href="admin.php?page=add-employee&action=view&empId=<?php echo $data -> id ?>" class="btn btn-info"> View </a>
                                        <a href="admin.php?page=add-employee&action=edit&empId=<?php echo $data -> id ?>" onClick="" class="btn btn-warning"> Edit </a>
                                        <a href="admin.php?page=employee-system&action=delete&empId=<?php echo $data -> id ?>" class="btn btn-danger"> Delete </a>
                                    </td>
                                </tr> 
                    <?php }}else{
                        echo "<tr><td><h4> No Employee found </h4></td></tr>";
                    } ?>
                </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
