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
firebase.Auth().signInAnonymously();

function updateAppointment(reference, data) {
    return firebase.database().ref(reference).update(data);
}

function storeUserImage(attch_file, callback) {
    let timestamp = Date.now();
    let storageRef = firebase.storage().ref('camera-invites/'+timestamp+'_'+attch_file.name);
    let metadata = {
        contentType: attch_file.type
    };

    storageRef.put(attch_file).then(function(snapshot) {
        var url = snapshot.downloadURL;
        return url;
        $('#image').val(url);
        callback();
    }).catch(function(error) {
        callback();
    });
}
