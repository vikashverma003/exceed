// Initialize Firebase
var config = {
    apiKey: "AIzaSyBt_34P2j2MCgQD_SbJGShAUuR-VIIQUh4",
    authDomain: "besttyme-f1bb2.firebaseapp.com",
    databaseURL: "https://besttyme-f1bb2.firebaseio.com",
    projectId: "besttyme-f1bb2",
    storageBucket: "gs://besttyme-f1bb2.appspot.com/",
//    messagingSenderId: "495790752817"
};
firebase.initializeApp(config);
firebase.auth().signInAnonymously();

function updateAppointment(reference, data) {
    return firebase.database().ref(reference).update(data);
}
function saveAppointment(reference, data, url) {
    
    firebase.database().ref(reference).update(data, function(error) {
        if(url) {
         window.location.href = url;
        } else {
         window.location.reload();
        }
    });
}
function deleteAppointment(reference, data) {
 var db = firebase.database();                   
 var ref = db.ref(); 
 var survey=db.ref(reference);               
 survey.child(data).remove();   
}
function storeUserImage(attch_file, callback) {
    let timestamp = Date.now();
    let storageRef = firebase.storage().ref('user_profile_photo/'+timestamp+'_'+attch_file.name);
    let metadata = {
        contentType: attch_file.type
    };

    storageRef.put(attch_file).then(function(snapshot) {
        var url = snapshot.downloadURL;
        $('#image').val(url);
        callback();
    }).catch(function(error) {
        callback();
    });
}

function storeinviteImage(attch_file, callback, current) 
{
    let timestamp = Date.now();
    let storageRef = firebase.storage().ref('camera-invite/'+timestamp+'_'+attch_file.name);
    let metadata = {
        contentType: attch_file.type
    };
    
    storageRef.put(attch_file).then(function(snapshot) {
        var url = snapshot.downloadURL;
        $('#image').val(url);
        callback(current); 

    }).catch(function(error) {
        callback(current);
    });
}
