Array.prototype.howMany = function(el) {
    var c = 0;
    for (var i = 0, j = this.length; i < j; i++) {
        if (this[i] == el) {
            c++;
        }
    }
    return c;
}


// ensure namespace object exists.
MasterMind = window.MasterMind || {};

// use module / singleton pattern to set up game.
MasterMind = (function() {
    /*
        Private variables used by game
    */

    var _myCode = [];
    var _currentGuess = [];
    var _guessList = []; // so guesses can be tracked and checked afterward.
    var _possibilities = [];
    var _numColors = 6;
    var _numPositions = 4;
    var _score = [];
    var _turns = 0;

    /* 
        Private functions
    */

    /*
        Description: checks to see if a guess with a given grade is compatible with a particular code.
                     the 'refinePossibilities' function loops through all current possibilities and
                     uses this function to test each one.
                     the computer's current guess is compared with the possibility being tested, and
                     a grade is given in the usual MasterMind form.  if this grade matches the grade
                     entered for the current guess, a value of TRUE is returned, indicating that this
                     possibility should be retained.
        Parameters:
            guess: array, four-color code guess.
            grade: string, grade received for guess. 
            code:  array, four-color potential match.  Function determines whether "code" is logical, given "guess" and "grade."
        Return:
            boolean: whether "code" is logically possible, given "guess" and "grade."
    */
    function _checkCriteria(guess, grade, code) {
        // copy arrays so originals are preserved
        var tmpGuess = guess.slice();
        var tmpCode = code.slice(); 

        var resultPegs = [];
        for (var i = 0; i < _numPositions; i++) {
            if (tmpGuess[i] == tmpCode[i]) {
                resultPegs.push('b');
                tmpGuess[i] = -1; // remove this guess "peg" so it can't be matched when "whites" are checked.
                tmpCode[i] = -2;  
            }
        }
        for (var i = 0; i < _numPositions; i++) {
            for (var j = 0; j < _numPositions; j++) {
                if (i != j && tmpGuess[i] == tmpCode[j]) {
                    resultPegs.push('w');
                    tmpGuess[i] = -1;
                    tmpCode[j] = -2;
                }
            }
        }
        return grade == resultPegs.join('');
    }

    /*
        Description: convert a decimal integer to a conventional Mastermind four-"color" code (essentially, decimal to base 6).
        Parameters:
            num: decimal integer to convert.
        Return:
            four-element array containing Mastermind "code" for this number.
    */
    function _toCode(num) {
        var code = [];
        var m;
        while (num != 0) {
            // _numColors is hardcoded to 6.
            m = num % _numColors;
            code.unshift(m);
            num = (num - m) / _numColors;
        }
        while (code.length < 4) {
            code.unshift(0);
        }
        return code;
    }

    return {
        /*
            public methods
                init: initializes the list of code possibilities (1,296 of them in the conventional game).
                takeGuess: randomly selects a guess from the current possibilities.
                refinePossibilities: compares guess and grade with each possibility, and removes illogical possibilities.
        */
        beginGuessCycle: function() {
            var guess = this.takeGuess();
            this.showGuess(guess);
        },

        takeGuess: function() {
            _score = []; // Initialize score for current guess.
            if (_possibilities.length == 0) {
                throw new Error("We seem to have arrived at an impossible situation.  Please check your scoring for errors.");
            }
            var ndx = Math.floor(_possibilities.length * Math.random());
            _currentGuess = _possibilities[ndx];
            _guessList.push(_currentGuess); // Keep record of guesses, in case we want to review them later.
            _turns++;
            return _currentGuess;
        },
    
        processScore: function() {
            var numPossibilities = this.refinePossibilities();
            if (numPossibilities == 0) {
                MasterMind.commentary("Based on the feedback you've provided, there are no possible solutions.");
            }
            this.report(numPossibilities);
            if (numPossibilities <= 1) {
                var guess = this.takeGuess();
                this.showGuess(guess);
                this.solved();
            }
            else {
                this.beginGuessCycle();
            }
        },

        refinePossibilities: function() {
            var grade = _score.join('');
            var newPossibilities = [];
            for (var i = 0; i < _possibilities.length; i++) {
                if (_checkCriteria(_currentGuess, grade, _possibilities[i])) {
                    newPossibilities.push(_possibilities[i]); 
                } 
            }
            _possibilities = newPossibilities;
            return _possibilities.length;
        },
    
        // Initialize set of possible codes.
        init: function() {
            var count = Math.pow(_numColors,_numPositions);
            for (var i = 0; i < count; i++) {
                _possibilities.push(_toCode(i));
            }
        },

        // getters, setters
        getScore: function() {
            return _score;
        },

        setScore: function(score) {
            _score = score.slice();
        },

        getTurns: function() {
            return _turns;
        },

        getPossibilities: function() {
            return _possibilities;
        },

        // UI methods
        showGuess: function(guess) {
            var peg;
            var pegs_left, pegs_top;
            var peg_row = document.createElement('div');
            peg_row.className = 'guess';
            for (var i = 0; i < guess.length; i++) {
                pegs_top = Math.floor(guess[i] / 3) * -16;
                pegs_left = guess[i] % 3 * -16;
                peg = document.createElement('div');
                peg.className = 'pegs';
                peg.style.backgroundPosition = pegs_left + 'px ' + pegs_top + 'px';
                $(peg_row).append(peg);
            }
            var score_card = document.createElement('div');
            score_card.className = 'scorecard';
            $(peg_row).append(score_card);
            $('#board').append(peg_row);
            peg_row.style.display = 'block';
            MasterMind.current_score_card = score_card;
        },

        comments: function(num) {
            var comments = 'Possible solutions: ' + num + '<br/>';
            return comments;
        },

        commentary: function(str) {
            var commentEl = document.createElement('p');
            commentEl.innerHTML = str;
            if (arguments.length == 2) {
                var pairs = arguments[1];
                for (var i = 0, j = pairs.length; i < j; i++) {
                    var el = document.createElement('p');
                    el.innerHTML = pairs[i]['label'];
                    el.onclick = pairs[i]['fn'];
                    el.className = 'confirmButton';
                    commentEl.appendChild(el);
                }
            }
            $('#output').html(commentEl);
        },

        confirmScore: function() {
            var that = this;
            var score = this.getScore();
            var blackCount = score.howMany('b');
            var whiteCount = score.howMany('w');
            if (blackCount == 0 && whiteCount == 0) {
                var msg = ["So I got nothing this time?"];
            }
            else {
                var msg = ["Just to be clear, I have:<br/>"];
                if (blackCount) {
                    msg.push(blackCount + " of the right color in the right place<br/> ");
                }
                if (whiteCount) {
                    msg.push(whiteCount + " of the right color but in the wrong place.<br/>");
                }
            }
            this.commentary(msg.join(''), [
                    {
                        label: "Yes, that's correct.",
                        fn: that.scoreConfirmed
                    },
                    {
                        label: "No, I seem to have made a mistake.  Let me redo.",
                        fn: that.scoreRedo
                    }]);
        },

        scoreConfirmed: function() {
            MasterMind.processScore();
        },

        scoreRedo: function() {
            MasterMind.clearScorePegs();
        },

        report: function(numPossibilities) {
            $('#output').html(this.comments(numPossibilities));
        },

        clearScorePegs: function() {
            _score = [];
            MasterMind.current_score_card.innerHTML = '';
        },

        // event handlers
        
        handleScore: function(id) {
            if (_score.length < 4) {
                var peg = document.createElement('div');
                if (id == 'black') {
                    _score.push('b');
                    peg.className = 'black_peg';
                }
                else { // id == 'white'
                    _score.push('w');
                    peg.className = 'white_peg';
                }
                $(MasterMind.current_score_card).append(peg);
            }
        },

        setCode: function(id) {
            if (_myCode.length < 4) {
                var peg = document.createElement('div');
                peg.className = 'colored_peg ' + id;
                $('#mycode').append(peg);
                _myCode.push(id);
            }
        },

        startGuesses: function() {
            $('#output').html('');
            MasterMind.beginGuessCycle();
        },

        scoreButtonClicked: function() {
//            MasterMind.processScore();
            MasterMind.confirmScore();
        //    MasterMind.confirmScore();
        },

        undoButtonClicked: function() {
            _score = [];
            $(MasterMind.current_score_card).html('');
        //    MasterMind.confirmScore();
        },

        restart: function() {
            _myCode = [];
            _currentGuess = [];
            _guessList = [];
            _possibilities = [];
            _score = [];
            _turns = 0;
            $('#mycode').html('');
            $('#board').html('');
            MasterMind.init();
        },

        solved: function() {
            MasterMind.commentary('<b>Looks like I\'m done!</b>; turns: ' + this.getTurns());
        },

        // TEST
        test: function() {
            var output = '';
            var scenario = [
                { guess: [4, 3, 1, 2], score: ['b'] },
                { guess: [5, 5, 1, 5], score: ['b'] },
                { guess: [5, 0, 0, 2], score: ['w'] },
                { guess: [1, 1, 1, 0], score: ['b', 'b', 'w', 'w'] }
            ];

            for (var s = 0, slen = scenario.length; s < slen; s++) {
                _currentGuess = scenario[s]['guess'];
                _score = scenario[s]['score'];
                var numPossibilities = MasterMind.refinePossibilities();
                output += '<b>' + numPossibilities + ' possibilities</b><br/>';
                for (var i = 0, j = _possibilities.length; i < j; i++) {
                    output += _possibilities[i].join(', ') + ' (' + (i+1) + ')<br/>';    
                }
                output += '<br/>';
                $('#output').html(output);
            }
        }


    };
})();



$(document).ready(function() {
    // Attach setCode to each of the colored pegs.
    $('.colored_peg').click(function() { MasterMind.setCode(this.id); });
    // Attach handleScore to each of the scoring pags.
    $('.score_peg').click(function() { MasterMind.handleScore(this.id);});

    // The four-color code has been set; when this button is clicked, it's time for the computer to begin solving.
    $("#set").click(function() { MasterMind.startGuesses(); });

    $("#solved").click(function() { MasterMind.solved(); });

    // The scoring pages have been selected; now the computer needs to evaluate and make another guess.
    $("#score").click(MasterMind.scoreButtonClicked);
    $("#undo").click(MasterMind.undoButtonClicked);

    $('#reset').click(MasterMind.restart);

    $('#test').click(MasterMind.test);

    MasterMind.init();

});

