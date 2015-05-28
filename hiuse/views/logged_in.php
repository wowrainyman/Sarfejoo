<!-- if you need user information, just put them into the $_SESSION variable and output them here -->
Hey, <?php echo $_SESSION['user_name']; ?>. You are logged in.<br/>
<a href="../bot/list.php">Bot List.php</a><br/>
<a href="../bot/sdb.php">Bot sdb.php</a><br/><br/>
<a href="../hidigi/list.php">Hidigi List.php</a><br/>
<a href="../hidigi/sdb.php">Hidigi sdb.php</a><br/><br/>
<a href="../hiuse/list.php">Hiuse List.php</a><br/><br/>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout">Logout</a>