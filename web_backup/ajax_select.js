var xmlHTTP;

function $_xmlHttpRequest()
{   
    if(window.ActiveXObject)
    {
        xmlHTTP=new ActiveXObject("Microsoft.XMLHTTP");
    }
    else if(window.XMLHttpRequest)
    {
        xmlHTTP=new XMLHttpRequest();
    }
}

function checkjob()
{  
    var select_op=document.getElementById("select_op").value;
    
    $_xmlHttpRequest();
    xmlHTTP.open("GET","ajax_job.php?select_op="+select_op,true);
    
        xmlHTTP.onreadystatechange=function check_user()
        {
            if(xmlHTTP.readyState == 4)
            {
                if(xmlHTTP.status == 200)
                {
                    var str=xmlHTTP.responseText;
                    document.getElementById("message").innerHTML=str;
                }
            }
        }
        xmlHTTP.send(null);
    }

function checkcourse()
{  
    var select_op=document.getElementById("select_op").value;
    
    $_xmlHttpRequest();
    xmlHTTP.open("GET","ajax_course.php?select_op="+select_op,true);
    
        xmlHTTP.onreadystatechange=function check_user()
        {
            if(xmlHTTP.readyState == 4)
            {
                if(xmlHTTP.status == 200)
                {
                    var str=xmlHTTP.responseText;
                    document.getElementById("message").innerHTML=str;
                }
            }
        }
        xmlHTTP.send(null);
    }