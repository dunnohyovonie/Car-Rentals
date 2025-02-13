<?php
//error_reporting(0);
if(isset($_POST['signup']))
{
    $fname = $_POST['fullname'];
    $email = $_POST['emailid']; 
    $mobile = $_POST['mobileno'];
    $password = md5($_POST['password']); 
    $sql = "INSERT INTO tblusers(FullName,EmailId,ContactNo,Password) VALUES(:fname,:email,:mobile,:password)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    if($lastInsertId)
    {
        echo "<script>alert('Registration successful. Now you can login');</script>";
    }
    else 
    {
        echo "<script>alert('Something went wrong. Please try again');</script>";
    }
}
?>

<!-- JavaScript -->
<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check_availability.php",
        data: 'emailid=' + $("#emailid").val(),
        type: "POST",
        success: function(data) {
            $("#user-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {}
    });
}

function valid() {
    // Correctly capture password and confirm password values
    var password = document.getElementById("password").value;
    var confirmpassword = document.getElementById("confirmpassword").value;

    // Debugging: Log the password values to the console
    console.log("Password:", password);
    console.log("Confirm Password:", confirmpassword);

    // Compare the two values
    if (password !== confirmpassword) {
        alert("Password and Confirm Password Field do not match!");
        document.getElementById("confirmpassword").focus();  // Focus on the confirm password field
        return false;  // Prevent form submission
    }
    
    return true;  // Allow form submission
}
</script>

<!-- Signup Form -->
<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 class="modal-title">Sign Up</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <!-- Correctly referencing the form and onSubmit function -->
              <form method="post" name="signup" id="signup" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Full Name" required="required">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="mobileno" placeholder="Mobile Number" maxlength="10" required="required">
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" onBlur="checkAvailability()" placeholder="Email Address" required="required">
                  <span id="user-availability-status" style="font-size:12px;"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required" checked="">
                  <label for="terms_agree">I Agree with <a href="#">Terms and Conditions</a></label>
                </div>
                <div class="form-group">
                  <button type="submit" name="signup" id="signup-btn" class="btn">Save  
                    <span class="angle_arrow">
                      <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Already got an account? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Login Here</a></p>
      </div>
    </div>
  </div>
</div>
