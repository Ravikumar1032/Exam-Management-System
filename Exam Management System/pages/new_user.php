<!--Body Starts Here-->
        <div class="main">
            <div class="content">
                <div class="report">
                    
                    <form method="post" action="" class="forms">
                        <h2>Student Registration</h2>
                        <?php 
                            if(isset($_SESSION['validation']))
                            {
                                echo $_SESSION['validation'];
                                unset($_SESSION['validation']);
                            }
                            if(isset($_SESSION['add']))
                            {
                                echo $_SESSION['add'];
                                unset($_SESSION['add']);
                            }
                        ?>
                        <span class="name">ID Number</span>
                        <input type="text" name="id_number" placeholder="ID Number" required="true" /><br />

                        <span class="name">First Name</span> 
                        <input type="text" name="first_name" placeholder="First Name" required="true" /> <br />
                        
                        <span class="name">Last Name</span>
                        <input type="text" name="last_name" placeholder="Last Name" required="true" /><br />
                        
                        <span class="name">Email</span>
                        <input type="email" name="email" placeholder="Email Address" required="true" /><br />
                        
                        <span class="name">Username</span>
                        <input type="text" name="username" placeholder="Username" required="true" /><br />
                        
                        <span class="name">Password</span>
                        <input type="password" name="password" placeholder="Password" required="true" /><br />
                        
                        <span class="name">Contact</span>
                        <input type="tel" name="contact" placeholder="Contact Number" /><br />
                        
                        <span class="name">Gender</span>
                        <input type="radio" name="gender" value="male" /> Male 
                        <input type="radio" name="gender" value="female" /> Female 
                        <input type="radio" name="gender" value="other" /> Other
                        <br />
                        
                        <span class="name">Faculty</span>
                        <select name="faculty">
                            <?php 
                                //Get Faculty from database
                                $tbl_name="tbl_faculty";
                                $where="is_active=('yes'||'no')";
                                $query=$obj->select_data($tbl_name,$where);
                                $res=$obj->execute_query($conn,$query);
                                $count_rows=$obj->num_rows($res);
                                if($count_rows>0)
                                {
                                    while($row=$obj->fetch_data($res))
                                    {
                                        $faculty_id=$row['faculty_id'];
                                        $faculty_name=$row['faculty_name'];
                                        ?>
                                        <option value="<?php echo $faculty_id; ?>"><?php echo $faculty_name; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo("<option value='none'>NONE</option>");
                                }
                            ?>
                        </select>
                        <br />
                        
                        <span class="name">Is Active?</span>
                        <input type="radio" name="is_active" value="yes" /> Yes 
                        <input type="radio" name="is_active" value="no" /> No
                        <br />
                        
                        <input type="submit" name="submit" value="Register Now" class="btn-add" style="margin-left: 15%;" />
                        <a href="<?php echo SITEURL; ?>index.php?page=login"><button type="button" class="btn-delete">Cancel</button></a>
                    </form>
                    <?php 
                        if(isset($_POST['submit']))
                        {
                            //Getting Values from the form
                            $id_number=$obj->sanitize($conn,$_POST['id_number']);
                            $first_name=$obj->sanitize($conn,$_POST['first_name']);
                            $last_name=$obj->sanitize($conn,$_POST['last_name']);
                            $email=$obj->sanitize($conn,$_POST['email']);
                            $username=$obj->sanitize($conn,$_POST['username']);
                            $password=hash('sha256', $obj->sanitize($conn, $_POST['password']));
                            $contact=$obj->sanitize($conn,$_POST['contact']);
                            if(isset($_POST['gender']))
                            {
                                $gender=$obj->sanitize($conn,$_POST['gender']);
                            }
                            else
                            {
                                $gender='male';
                            }
                            
                            $faculty=$obj->sanitize($conn,$_POST['faculty']);
                            if(isset($_POST['is_active']))
                            {
                                $is_active=$_POST['is_active'];
                            }
                            else
                            {
                                $is_active='yes';
                            }
                            $added_date=date('Y-m-d');
                            
                            //Backend Validation, Checking whether the input fields are empty or not
                            if(($id_number||$first_name||$last_name||$email||$username||$password)==null)
                            {
                                //SET SSESSION Message
                                $_SESSION['validation']="<div class='error'>First Name or Last Name, or Email or Username or Password is Empty.</div>";
                                header('location:'.SITEURL.'admin/index.php?page=add_student');
                            }
                            
                            //Addding to the database
                            $tbl_name='tbl_student';
                            $data="id_number='$id_number',
                                    first_name='$first_name',
                                    last_name='$last_name',
                                    email='$email',
                                    username='$username',
                                    password='$password',
                                    contact='$contact',
                                    gender='$gender',
                                    faculty='$faculty',
                                    is_active='$is_active',
                                    added_date='$added_date',
                                    updated_date=''";
                            $query=$obj->insert_data($tbl_name,$data);
                            $res=$obj->execute_query($conn,$query);
                            if($res===true)
                            {
                                $_SESSION['add']="<div class='success'>You Are Successfully Registered.</div>";
                                header('location:'.SITEURL.'index.php?page=login.php');
                            }
                            else
                            {
                                $_SESSION['add']="<div class='error'>Failed to add new student. Try again.</div>";
                                header('location:'.SITEURL.'index.php?page=register.php');
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <!--Body Ends Here-->