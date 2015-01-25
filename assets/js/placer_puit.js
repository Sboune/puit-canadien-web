  var mat = new THREE.MeshBasicMaterial({ color: "#33312E", wireframe:false });
  var Geo = new THREE.CylinderGeometry(8/2, 8/2, 40, 8, 1); 
  var Geo2 = new THREE.CylinderGeometry(8/2, 8/2, 744, 8, 1); 
  var Geo3 = new THREE.CylinderGeometry(8/2, 8/2, 455/2, 8, 1); 
  var Geo4 = new THREE.CylinderGeometry(8/2, 8/2, 28, 8, 1); 
  var p = new THREE.Mesh(Geo, mat);
  p.position.set(850/2, 414/2-XOFFSET, 550/2);
  p.name = "Puit Canadien";
  scene.add(p);

  var p1 = new THREE.Mesh(Geo2, mat);
  p1.position.set(125/2, 200/2-XOFFSET, 550/2);
  p1.rotation.z = 104 * (Math.PI / 180);
  p1.name = "Puit Canadien";
  scene.add(p1);
  
  var p2 = new THREE.Mesh(Geo3, mat);
  p2.position.set(-720/2, 205/2-XOFFSET, 550/2);
  p2.rotation.z = 34 * (Math.PI / 180);
  p2.name = "Puit Canadien";
  scene.add(p2);
  
  var p3 = new THREE.Mesh(Geo4, mat);
  p3.position.set(-848/2, 418/2-XOFFSET, 550/2);
  p3.name = "Puit Canadien";
  scene.add(p3);