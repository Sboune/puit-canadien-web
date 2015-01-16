

var cA = ['sonde 2m', 10, 5, 6, 9, 4, 10, 5, 6, 9, 4, 10, 5, 6, 9, 4, 10, 5, 6, 9, 4, 10, 5, 6, 9, 4];
var cB = ['sonde 3m', 17, 20, 10, 5, 3, 17, 20, 10, 5, 3, 17, 20, 10, 5, 3, 17, 20, 10, 5, 3, 17, 20, 10, 5, 3];
var cC = ['sonde 1.5m', 12, 14, 11, 10, 8, 12, 14, 11, 10, 8, 12, 14, 11, 10, 8, 12, 14, 11, 10, 8, 12, 14, 11, 10, 8];

var chart5 = c3.generate({
	// dans quel id afficher
	bindto: '#chart',
	//charge les données
	data: {
		columns: [cA, cB, cC]
	},
  color: {
        pattern: ['#27636D', '#FA7577', '#C5DFA2', '#E04B21', '#7ED8CC', '#A30E14', '#14699A', '#C16EB0', '#DD2A2F', '#27A39F', '#E94F51', '#544679', '#FAC763', '#998EB6', '#9E2E73', '#FA9247']
  },
  subchart: {
    show: true
  }

});
