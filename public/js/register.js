//register functions
 
//function to reveal school dropdown  
function reveal_schools()
{
        
    if(document.getElementById('roles_id').value === '1' || document.getElementById('roles_id').value === '2')
    {
            document.getElementById('school_id').form['2'].style.display='block';
    } else {
            document.getElementById('school_id').form['2'].style.display='none';
    }

}

function reveal_entrepreneur_form()
{
    if (document.getElementById('roles_id').value === '1' || document.getElementById('roles_id').value === '2'){
        document.getElementById('companies').form['3'].style.display='none';
        document.getElementById('aEmail').form['6'].style.display='block';
        document.getElementById('bEmail').form['7'].style.display='block';
        document.getElementById('email').form['8'].style.display='none';
        
    }
   if (document.getElementById('roles_id').value === '3'){
        document.getElementById('companies').form['3'].style.display='block';
        document.getElementById('aEmail').form['6'].style.display='none';
        document.getElementById('bEmail').form['7'].style.display='none';
        document.getElementById('email').form['8'].style.display='block';
        
    }
}


//function to automatically put email domains(@example.com) in input_field
function set_input_value()
{

    if(document.getElementById('school_id').value==='1'){
        document.getElementById('bEmail').value='@fcroc.nl';
        document.getElementById('bEmail').readOnly = true;

    }
    if(document.getElementById('school_id').value==='2'){
        document.getElementById('bEmail').value='@student.nhl.nl';
        document.getElementById('bEmail').readOnly = true;
    }
    if(document.getElementById('school_id').value==='3'){
        document.getElementById('bEmail').value='@edu.rocfriesepoort.nl';
        document.getElementById('bEmail').readOnly = true;
    }
    if(document.getElementById('school_id').value==='4'){
        document.getElementById('bEmail').value='@gmail.com';
        document.getElementById('bEmail').readOnly = true;
    }
}

//fuction to combine the two email input_fields
function fuse_email()
{
    var aEmail = document.getElementById('aEmail').value;
    var bEmail = document.getElementById('bEmail').value;
    var result = document.getElementById('email');
    var email = aEmail + bEmail;
    result.value = email;  


    console.log(email);
}
