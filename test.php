<?php 
$userid = $_POST['userid'];
$friend = $_POST['friend'];
$json_data = file_get_contents('myTutorials.txt');
$data = json_decode($json_data);
$friends=explode(",",$data[$userid]->requests);
$friends1=explode(",",$data[$userid]->friends);
$flag1=1;
foreach($friends as $i){
if($i==$friend)
{$flag1=0;}
}
foreach($friends1 as $i){
if($i==$friend)
{$flag1=0;}
}
if($flag1)
{
$check=explode(",",$data[$friend]->requests);
$flag=1;
foreach($check as $i){
if($i==$userid)
{$flag=0;}
}
if($flag)
{
if($data[$userid]->requests != null)
{
$data[$userid]->requests = $data[$userid]->requests.",".$friend;
}
else{
$data[$userid]->requests = $data[$userid]->requests.$friend;}
$json_data= json_encode($data,JSON_PRETTY_PRINT);
file_put_contents('myTutorials.txt',$json_data);
}
else
{
if($data[$userid]->friends != null)
{
$data[$userid]->friends = $data[$userid]->friends.",".$friend;
$data[$friend]->friends = $data[$friend]->friends.",".$userid;
}
else{
$data[$userid]->friends = $data[$userid]->friends.$friend;
$data[$friend]->friends = $data[$friend]->friends.$userid;
}
$json_data= json_encode($data,JSON_PRETTY_PRINT);
file_put_contents('myTutorials.txt',$json_data);
}
}
echo $json_data;
header("Location: home.php");
?>

