<!--Body Starts Here-->
        <div class="main">
            <div class="login">
                <form method="post" action="">
                    <h2>LOG-IN</h2>
                    <?php 
                        if(isset($_SESSION['invalid']))
                        {
                            echo $_SESSION['invalid'];
                            unset($_SESSION['invalid']);
                        }
                    ?>
                    <input type="text" name="username" placeholder="Username" required="true" />
                    <input type="password" name="password" placeholder="Password" required="true" />
                    <input type="submit" name="submit" value="Log In" class="btn-go" />
                    <input type="reset" name="reset" value="Reset" class="btn-exit" />
                    <br><br>
                   
                        Hey New User ?  <a href="<?php echo SITEURL; ?>index.php?page=new_user"><button type="button" class="btn-add">Register Here</button></a>
                        <?php
                        if(isset($_SESSION['add']))
                        {
                            echo $_SESSION['add'];
                            unset($_SESSION['add']);
                        }
                        if(isset($_SESSION['update']))
                        {
                            echo $_SESSION['update'];
                            unset($_SESSION['update']);
                        }
                        if(isset($_SESSION['delete']))
                        {
                            echo $_SESSION['delete'];
                            unset($_SESSION['delete']);
                        }
                    ?>
                </form>
                <?php 
                    if(isset($_POST['submit']))
                    {
                        //echo "CLicked";
                        //Get Values from forms
                        $username=$obj->sanitize($conn,$_POST['username']);
                        $password=hash('sha256', $obj->sanitize($conn, $_POST['password']));
                        //Check Login
                        $tbl_name="tbl_student";
                        $where="username='$username' && password='$password' && is_active='yes'";
                        $query=$obj->select_data($tbl_name,$where);
                        $res=$obj->execute_query($conn,$query);
                        $count_rows=$obj->num_rows($res);
                        if($count_rows>0)
                        {
                            $_SESSION['student']=$username;
                            $_SESSION['login']="<div class='success'>Login Successful.</div>";
                            header('location:'.SITEURL.'index.php?page=welcome');
                        }
                        else
                        {
                            $_SESSION['invalid']="<div class='error'>Username or Password is invalid.</div>";
                            header('location:'.SITEURL.'index.php?page=register');
                        }
                    }
                ?>
            </div>
        </div>
        <!--Body Ends Here-->