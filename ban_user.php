<?php
    include_once 'header.php';
    include_once 'database.php';
    //poiščemo vse uporabnike,ki niso admini
    $query = "SELECT * FROM users WHERE (administrator != 1)";
    $result = mysqli_query($link, $query);		
?>
    <form action="update_user_status.php" method="get">
	Choose a user:<br>
	<select name="user"> 
        <?php
            while ($row = mysqli_fetch_array($result)){?>
                <option value="<?php echo $row['id']?>"><?php echo $row['username']?></option>
        <?php }?>
	</select><br>
	Ban until:<br>
	<input type="datetime-local" name="date"><br>
	<input type="submit" value="Ban" />
    </form>
<?php
    include_once 'footer.php';