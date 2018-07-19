<p><strong><u>Description:</u></strong></p>
<p>TyBank Online Banking is an online banking simulator that mimics an online electronic payment system, enabling TyBank customers to perform a range of financial transactions. This project includes both a website for the Online Banking simulation interface, and an admin software to read and write onto the database of the banking simulator.</p>
<p>What TyBank Online Banking can do:</p>
<ul>
<li>View accounts</li>
<li>View, filter, and export transaction data</li>
<li>Pay bills</li>
<li>Send money</li>
</ul>
<p>The <a href="https://github.com/markytools/tybank-admin">admin</a> software, which is written in C++ using the Qt Framework, are use to modify the system&rsquo;s database. Examples of the actions that this application can do is:</p>
<ul>
<li>Create new accounts for new/existing customers</li>
<li>Perform ATM transactions such as depositing or withdrawing cash</li>
<li>Sending email notifications</li>
</ul>
<p>&nbsp;</p>
<p><span style="text-decoration: underline;"><strong>Setup/Requirements:</strong></span></p>
<p>First, you need to setup an online/remote MySQL database. Use the TyBank database sql file to import the TyBank database tables into the online MySQL database, and remember to replace line 10 &ldquo;USE database_name;&rdquo; of that file with your database name. (You can use phpMyAdmin to import this file)</p>
<p>(Note: The database setting is configured to use our free heliohost database, but if you want to create your own database, you can change the configs on your own at the connection.php file)</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<hr/>
<p><strong>Using the Simulator:</strong></p>
<p>In order to login, you need to have an online TyBank Account first. To do this, go to the registration link page. An online bank account is the account representation of a person using the services of the TyBank website. But in order to do this, you need to have a real bank account first. This can be created using the TyBank Admin app. You cannot create an online TyBank account if you haven&rsquo;t created a bank account yet.</p>
<p>After creating a bank account, go to the registration page of the TyBank website (register.php) and then register an online bank account. Note that you need to enter the correct First Name, Middle Name, Last Name, and Account Number that you have used with the TyBank Admin app. If you have multiple account number, any one of those account numbers can be used. An error would occur if any of the data does not match the specified inputs. After that, you can create yourself a username, email, and password for the account. If successful, you will be logged in by the system.</p>
<p>In the main screen, you will see 4 options:</p>
<ul>
<li>My Accounts</li>
<li>View Transactions</li>
<li>Bills Payment</li>
<li>Send Money</li>
</ul>
<p>These are the TyBank online banking services currently available the moment. Now, you can play with any of them if you want!</p>
<p>&nbsp;</p>
<p><span style="text-decoration: underline;"><strong>Screenshots:</strong></span></p>
<p><img src="https://raw.githubusercontent.com/markytools/tybankonline/master/other/screenshot1.png" alt="" width="1035" height="466" /></p>
<p><img src="https://raw.githubusercontent.com/markytools/tybankonline/master/other/screenshot2.png" alt="" width="1036" height="461" /></p>
<p><img src="https://raw.githubusercontent.com/markytools/tybankonline/master/other/screenshot3.png" alt="" width="1036" height="467" /></p>
