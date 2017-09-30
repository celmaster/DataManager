/* Biblioteca de funcoes javascript
 *
 * Marcelo Barbosa,
 * agosto, 2016.
 */


// variaveis globais 


// declaracao de funcoes
function exist(id)
{
    // verifica se um elemento existe
    // declaracao de variaveis
    var status = false;

    if (document.getElementById(id))
    {
        status = true;
    }

    // retorno de valor
    return status;
}

function showNavbar(status)
{
    // exibe a navbar
    if (exist("navbar") && exist("darkbackground") && exist("navbutton"))
    {
        // declaracao de variaveis
        var navbar = document.getElementById("navbar");
        var background = document.getElementById("darkbackground");
        var navbutton = document.getElementById("navbutton");

        // altera as classes
        if (status)
        {
            navbutton.className = "nonDisplay";
            navbar.className = "navbar";
            background.className = "darkbackground";
        } else
        {
            navbar.className = "nonDisplay";
            background.className = "nonDisplay";
            navbutton.className = "navbutton";
        }
    }
}

function navLink(id)
{
    // faz navegacao de conteudo por id
    // oculta a navbar
    showNavbar(false);

    // realiza a navegacao
    window.location.href = "#" + id;
}

function navPage(page)
{
	// faz navegacao de conteudo por pagina
	// oculta a navbar
	showNavbar(false);
	
	// realiza a navegacao
	window.location.href = page;
}

function sendForm(id)
{
    // envia um formulario
    if (exist(id))
    {
        document.getElementById(id).submit();
    }
}

function saveUser(formId)
{
    // envia os dados de um usuario para se registrar no sistema
    if (exist(formId))
    {
        if (exist("usernameSaveForm") && exist("passwordSaveForm") && exist("confirmPasswordSaveForm"))
        {
            var username = document.getElementById("usernameSaveForm").value;
            var userpassword = document.getElementById("passwordSaveForm").value;
            var confirmPassword = document.getElementById("confirmPasswordSaveForm").value;

            // premissas			
            var statement1 = (username != "") && (userpassword != "") && (confirmPassword != "");
            var statement2 = userpassword == confirmPassword;

            if (statement1)
            {
                if (statement2)
                {
                    sendForm(formId);
                } else
                    {
                        alert("Os passwords não conferem!");
                    }

            } else
            {
                alert("Os campos estão vazios!");
            }
        }
    }
}

function login(formId)
{
    // envia os dados de um usuario para se registrar no sistema
    if (exist(formId))
    {
        if (exist("username") && exist("password"))
        {
            var username = document.getElementById("username").value;
            var userpassword = document.getElementById("password").value;

            // premissas
            var statement = (username != "") && (userpassword != "");

            if (statement)
            {
                sendForm(formId);
            } else
                {
                    alert("Os campos estão vazios!");
                }
        }
    }
}

function makeTemplate(formId)
{
    // submete dados para criar um template
    if (exist(formId))
    {
        if (exist("resourceName") && exist("className"))
        {
            var resourceName = document.getElementById("resourceName").value;
            var className = document.getElementById("className").value;

            // premissas
            var statement = (resourceName != "") && (statement != "");

            if (statement)
            {
                sendForm(formId);
            } else
                {
                    alert("Os campos estão vazios!");
                }
        }
    }
}

function makeGrid(formId)
{
    // submete dados para criar um template
    if (exist(formId))
    {
        if (exist("gridContent"))
        {
            var gridContent = document.getElementById("gridContent").value;

            // premissas
            var statement = gridContent != "";

            if (statement)
            {
                sendForm(formId);
            } else
                {
                    alert("Insira o código da grid para modelagem!");
                }
        }
    }
}

function updateUser(formId)
{
    // envia os dados de um usuario para se registrar no sistema
    if (exist(formId))
    {
        if (exist("usernameUpdateForm") && exist("oldPasswordUpdateForm") && exist("newPasswordUpdateForm")&& exist("confirmPasswordUpdateForm"))
        {
            var username = document.getElementById("usernameUpdateForm").value;
            var oldpassword = document.getElementById("oldPasswordUpdateForm").value;
            var newpassword = document.getElementById("newPasswordUpdateForm").value;
            var confirmPassword = document.getElementById("confirmPasswordUpdateForm").value;

            // premissas			
            var statement1 = (username != "") && (oldpassword != "") && (newpassword != "") && (confirmPassword != "");
            var statement2 = oldpassword != newpassword
            var statement3 = newpassword == confirmPassword;

            if(statement1)
            {
                if(statement2)
                {
                    if(statement3)
                    {
                        sendForm(formId);
                    }else
                        {
                            alert("Novo password não confere com o campo de confirmação");
                        }
                } else
                    {
                        alert("Novo password é igual ao atual");
                    }

            } else
                {
                    alert("Os campos estão vazios!");
                }
        }
    }
}