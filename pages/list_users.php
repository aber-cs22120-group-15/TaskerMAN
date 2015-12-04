<?php


WebInterface\WebInterface::setTitle('Manage Users');


$UserData = TaskerMAN\UserListInterface::getUsers();
?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

	<h2 class="page-header">Users</h2>
	<h4><a href="index.php?p=new_user">Create new user</a></h4>
	<div class="table-responsive">

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th style="text-align: center;">ID</th>
          <th>Name</th>
          <th>Email</th>
          <th style="text-align: center;">Admin Status</th>
        </tr>
      </thead>

      <tbody>

      <?php
      foreach ($UserData as $user){

     
        echo '<tr>';
        echo '<td style="text-align: center;">' . $user['id'] . '</td>';
        echo '<td><a href="index.php?p=user&amp;id=' . $user['id'] . '">' . $user['name'] . '</a></td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td style="text-align: center;">';

        if ($user['admin'] == 1){
        	echo '<span style="color: green">&#10004;</span>';
        } else {
        	echo '<span style="color: red">&#10008;</span>';
        }

        echo '</td>';
        echo '</tr>';

      }

      ?>

      </tbody>
    </table>
	</div>
</div>