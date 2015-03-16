function placer_sonde(nom, x, y, z){
  var sondeTexture = new THREE.MeshBasicMaterial({color:"#FFFFFF",wireframe:false});
  console.log(nom);
  var length = nom.match(/\d+/)[0]
  var finalLength = 0;
  console.log(length);
  length == 70 ? finalLength = 70 : finalLength = 80;
  var sondeGeometry = new THREE.CylinderGeometry(6/2,6/2,finalLength*10, 8, 1);
  var sonde1 = new THREE.Mesh(sondeGeometry, sondeTexture);
  var sonde2 = new THREE.Mesh(sondeGeometry, sondeTexture);
  var sonde3 = new THREE.Mesh(sondeGeometry, sondeTexture);
  var sonde4 = new THREE.Mesh(sondeGeometry, sondeTexture);
  sonde1.position.set(x,y,z);
  sonde2.position.set(x+20,y,z+20);
  sonde3.position.set(x,y,z+40);
  sonde4.position.set(x-20,y,z+20);
  sonde1.name = "Sonde" + nom;
  sonde2.name = "Sonde" + nom;
  sonde3.name = "Sonde" + nom;
  sonde4.name = "Sonde" + nom;
  scene.add(sonde1);
  scene.add(sonde2);
  scene.add(sonde3);
  scene.add(sonde4);
}