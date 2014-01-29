
<div class="container">
    <div class="row block">
        <div class="span4">
            <h2>Find some really cool products</h2>
            <p class="lead">The store contains some really nice products. This is how it works, you search and reserve the item that you want and then come on the next day and pick it up</p>
        
            <a href="#register" role="button" data-toggle="modal" class="btn btn-info btn-large">Register</a>
            <a href='<?php echo $this->createUrl("item/index") ?>' class="btn btn-success btn-large">See all items</a>
       </div>
        
        <div class="span8">
            <img src="<?php echo Yii::app()->baseUrl . "/images/tablet.jpg"; ?>" height=50px alt="">
        </div>
    </div>
</div>

            <div id="register" class="modal hide fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header" style="background-color: #2f96b4;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 id="myModalLabel">Register</h3>
                </div>
                <div class="modal-body">
                
                <?php 
                
                $model=new User;
                ?>



                <form class="form-horizontal well" id="user-form" action="<?php echo $this->createUrl('/register'); ?>" method="post">

                <div class="control-group">
                    <label class="control-label">First Name</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input class="span4 required" maxlength="255" name="User[first]" id="User_first" type="text"><br>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Last Name</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>    
                            <input class="span4 required" maxlength="255" name="User[last]" id="User_last" type="text">  <br>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-envelope"></i></span>
                            <input class="span4 required" maxlength="255" name="User[email]" id="User_email" type="text"> <br>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Username</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>    
                            <input class="span4 required" maxlength="255" name="User[username]" id="User_email" type="text"> <br>
                        </div>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Password</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input class="span4 required" maxlength="255" name="User[password]" id="User_password" value="" type="password"><br>
                        </div>
                    </div>
                </div>


                <div class="control-group">
                    <label class="control-label">Confirm Password</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input class="span4 required" maxlength="255" name="User[password_repeat]" id="User_password_repeat" value="" type="password"><br>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <div class="modal-footer">
                            <button class="btn btn-info btn-large pull-left" type="submit" name="yt0">Create Account</button>
                        </div>
                    </div>
                </div>

                </form>

            </div>
    </div>
</div>