var hash = [
  ["0", "G"],
  ["1", "v"],
  ["2", "E"],
  ["3", "t"],
  ["4", "q"],
  ["5", "U"],
  ["6", "j"],
  ["7", "a"],
  ["8", "P"],
  ["9", "L"],
  [".", "m"],
  ["#", "Z"],
];
// FFFFFFFFXX: FF-0~255 hex, XX-hash projectID
function makeKeyFromID(projectid) {
  var encryptedProjectid = encrypt(projectid);
  return makeRandomString(12) + encryptedProjectid;
}

function getInfoFromKey(key) {
  // return [decrypt(key).split("#")[0], decrypt(key).split("#")[1]]; //origin
  var encryptedProjectid = key.substring(12);
  var projectid = decrypt(encryptedProjectid);
  return projectid.split('');
}

function encrypt(string) {
  var result = String(string);
  for (var x in hash) {
    result = result.replaceAll(hash[x][0], hash[x][1]);
  }
  return result;
}

function decrypt(string) {
  var result = string;
  for (var x in hash) {
    result = result.replaceAll(hash[x][1], hash[x][0]);
  }
  return result;
}

function makeRandomString(length) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}
