/* Password strength indicator */
function passwordStrength(password, passDifficulty, passLength) {

    var desc = [{ 'width': '0px' }, { 'width': '20%' }, { 'width': '40%' }, { 'width': '60%' }, { 'width': '80%' }, { 'width': '100%' }];

    var descClass = ['', 'progress-bar-danger', 'progress-bar-danger', 'progress-bar-warning', 'progress-bar-success', 'progress-bar-success'];

    var score = 0;

    // //if password bigger than 6 give 1 point
    // if (password.length > 6) score++;

    // //if password has both lower and uppercase characters give 1 point
    // if ((password.match(/[a-z]/)) && (password.match(/[A-Z]/))) score++;

    // //if password has at least one number give 1 point
    // if (password.match(/\d+/)) score++;

    // //if password has at least one special caracther give 1 point
    // if ( password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) )	score++;

    // //if password bigger than 12 give another 1 point
    // if (password.length > 10) score++;

    if (passDifficulty == 1)
    {
        if (password.length >= passLength) {
            if (password.length >= (passLength + 4))
                score = 5;
            else
                score = 4;
        } else {
            if (password.length <= (passLength - 4))
                score = 1;
            else
                score = 2;
        }
    }
    if(passDifficulty == 2)
    {
        if (password.length >= passLength)
        {
            score++;
            score++;
        }
        if ((password.match(/[a-z]/)) || (password.match(/[A-Z]/)))
        {
            score++;
        }
        if (password.match(/\d+/))
        {
            score++;
            score++;
        }
        // if (password.length >= (parseInt(passLength) + 2))
        // {
        //     score++;
        // }
    }
    if(passDifficulty == 3)
    {
        if (password.length >= passLength)
        {
            score = score + 2;
        }
        if ((password.match(/[a-z]/)) || (password.match(/[A-Z]/)))
        {
            score++;
        }
        if (password.match(/\d+/))
        {
            score++;
        }
        if (password.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))
        {
            score++;
        }
    }
    if(score >= 4)
    {
        $("#jak_pstrength").removeClass(descClass[1]);
        $("#jak_pstrength").removeClass(descClass[3]);
    }
    if(score == 3)
    {
        $("#jak_pstrength").removeClass(descClass[1]);
        $("#jak_pstrength").removeClass(descClass[4]);
    }
    if(score < 3 && score > 0)
    {
        $("#jak_pstrength").removeClass(descClass[3]);
        $("#jak_pstrength").removeClass(descClass[4]);
    }
    if(score == 0)
    {
        $("#jak_pstrength").removeClass(descClass[1]);
        $("#jak_pstrength").removeClass(descClass[3]);
        $("#jak_pstrength").removeClass(descClass[4]);
    }
    // display indicator
    $("#jak_pstrength").addClass(descClass[score]).css(desc[score]);
}
