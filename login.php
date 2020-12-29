<?php include "init.php"?>

    <div class="container">
        

        <form action="" class="login">

            <h1>Log In</h1>
            <input type="email" name="email" autocomplate="off" placeholder="Email" required/>
            <input type="password" name="password" autocomplate="new-password" placeholder="Password" required/>
            <p>create new acount?<a href="#">sign up</a></p>
            <input type="submit" value="log in"/>

        </form>

        <form action="" class="signup">

            <h1>Sign Up</h1>
            <input type="email" name="email" autocomplate="on" placeholder="Email" required />
            <input type="password" name="password" autocomplate="new-password" placeholder="password" required/>
            <input type="password" name="valid-password" autocomplate="newèpassword" placeholder="retype password" required/>
            <p>already a member?<a href="">log in</a></p>
            <input type="submit" value="Sign Up"/>

        </form>
    </div>


<?php include $template . "footer.php"?>