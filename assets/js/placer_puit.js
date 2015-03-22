  var mat = new THREE.MeshBasicMaterial({ color: "rgb(44, 62, 80)", wireframe:false });
  var Geo = new THREE.CylinderGeometry(10/2, 10/2, 55, 8, 1); 
  var Geo2 = new THREE.CylinderGeometry(10/2, 10/2, 805, 8, 1); 
  var Geo3 = new THREE.CylinderGeometry(10/2, 10/2, 214/2, 8, 1); 
  var Geo4 = new THREE.CylinderGeometry(10/2, 10/2, 24, 8, 1);
  var p = new THREE.Mesh(Geo, mat);
  p.position.set(850/2, 380/2-XOFFSET, 550/2);
  p.name = "Puit Canadien";
  scene.add(p);

  var p1 = new THREE.Mesh(Geo2, mat);
  p1.position.set(50/2, 275/2-XOFFSET, 550/2);
  p1.rotation.z = 94 * (Math.PI / 180);
  p1.name = "Puit Canadien";
  scene.add(p1);
  
  var p2 = new THREE.Mesh(Geo3, mat);
  p2.position.set(-800/2, 305/2-XOFFSET, 550/2);
  p2.rotation.z = 28 * (Math.PI / 180);
  p2.name = "Puit Canadien";
  scene.add(p2);
  
  var p3 = new THREE.Mesh(Geo4, mat);
  p3.position.set(-850/2, 420/2-XOFFSET, 550/2);
  p3.name = "Puit Canadien";
  scene.add(p3);