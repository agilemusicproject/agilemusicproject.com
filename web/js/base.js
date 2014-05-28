function visitMembersPage() {
    window.location='http://amp.local/bandMembers';
}

function createContact() {
    var name = document.getElementById('form_name').value;
    var email = document.getElementById('form_email').value;
    var message = document.getElementById('form_message').value;
    
    var newP = document.createElement('p');
//    var newA = newP.appendChild('a');
//    newA.Id = name.substr(0,5);
//    newA.href = "mailto:" + email;
    newP.className = "contactPageText";
    newP.textContent = message;
    document.getElementById('contactBand').appendChild(newP);
}