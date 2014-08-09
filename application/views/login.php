<html>
    <head>
        <title>Login</title>

    <link rel="stylesheet" href="<?php echo base_url();?>/css/test.css"/>
    <meta charset="UTF-8"/>
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>-->
    <script type="text/javascript" src="<?php echo base_url();?>/js/jquery-1.6.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/js/jquery.cycle.all.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/js/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>/js/testscript.js"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>-->
    
    

    </head>
    <body>
        
       <?php echo $error_msg;?> 
        <?php echo validation_errors(); ?> 
        <?php echo form_open('users_controller/login'); ?>

        <h1>Collabor8</h1>
   
    <!--<div id="imgs">
    <image src="images/apple3.jpg" width="550" height="400" alt=""/>
    </div>-->
    <div id="pos">
    <div class="til"><div class="square">

        <a href="http://localhost/taskmanager/index.php/Register/sign_up"><div class="tile1 tilecolor2">
           <span class="title2">SIGN UP</span><br/>
        </div>
        </a>
        <div class="tile2 smalltile tilecolor3"><a href="http://localhost/taskmanager/index.php/Fb/"><img src="<?php echo base_url();?>/images/fbbutton.png" width="100" height="85" /></a>
        </div>
          
        </div>
   
        <div class="square">
        
        <div class="tile lartile tilecolor1">
        
          <span class="title1">LOGIN</span><br/>
        
       
    </div>
          

   <div class="bigtile tilecolor1">
          <div id="styl">
            
            <form>
            <!--<span class="formtitle">LOGIN</span><br/>-->
            
            <center>
                
            <p>
            <input type="text" id="username" name="username" placeholder="username">
                </p>
                <p>
        
            <input type="password" id="password" name="password" placeholder="password">  
                </p>
             
            <input type="submit"/> 
              </center>
           </form>
         </div>
</div>
        
        
        
        </div>

        <div class="square"> <!--start of 3rd row tiles -->

        <div class="tile5 mediumtile tilecolor6">
        </div>
        
        <div class="tile6 mediumtile tilecolor7">
        </div>
          
        </div> <!-- end of 3rd row tiles --> 
      
        
    </div>
</div>
<div id="pos1">
<div class="til">
  <div class="square">
        <div class="tile7">
           <img src="<?php echo base_url();?>/images/img1.jpg" width="545" height="125" />
           <img src="<?php echo base_url();?>/images/img2.jpg" width="545" height="125" />
           <img src="<?php echo base_url();?>/images/img3.jpg" width="545" height="125" />
        </div>
    </div>
        
        <div class="square">
        <div class="tile3 tilecolor4">
           <span class="title3"><center> A web-based project-management tool developed by Dolojo</center></span><br/>
        </div>
        
        <div class="tile4 tilecolor5">
          <span class="title3"> Learn More</span><br/>
        </div>
          
    </div>
</div>
   
</div>
    </body>
</html>