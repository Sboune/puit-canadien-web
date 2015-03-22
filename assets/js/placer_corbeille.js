function placer_corbeille(nom, x, y, z) {
  var Geo = new THREE.CylinderGeometry(6, 6, 330/2, 8, 1, true);
  var Mat = new THREE.MeshBasicMaterial({ color:"rgb(255,255,255)", wireframe:false });
  if(nom == "D1" || nom == "D2" || nom == "D3"){
  	Mat = new THREE.MeshBasicMaterial({ color:"rgb(171, 183, 183)", wireframe:false });
  }
  if(nom == "E1" || nom == "E2" || nom == "E3"){
  	Mat = new THREE.MeshBasicMaterial({ color:"rgb(104, 109, 124)", wireframe:false });
  }
  var corb = new THREE.Mesh(Geo, Mat);
  corb.name = "Corbeille "+nom;
  corb.position.set(x/2, (y/2)-XOFFSET - 22, z/2);
  scene.add(corb);
}