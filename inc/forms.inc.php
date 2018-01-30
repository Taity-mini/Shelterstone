<?php

// @author Alan Thom (1103803)
// Contains functions to return a new form item, previously submitted form item, or an invalid form item with an attached error


function formStart($required = true)
{
    if ($required) {
        return '<form action="" method="post">
                <div class="row">
                    <div class="large-12 medium-12 small-12 columns"> 
                            <p class="required">* indicates a required field</p>
                            <div class="row">';
    } else {
        return '<form action="" method="post">
                <div class="row">
                    <div class="large-12 medium-12 small-12 columns"> 
                            <div class="row">';
    }
}

function linkButton($text, $link, $news = false)
{
    if ($news) {
        return '<div class="large-6 large-centered medium-6 medium-centered small-12 small-centered columns">
                <a href="' . $link . '" class="medium radius button middle centre h6 capitalise">' . $text . '</a>
            </div>';
    } else {
        return '</div><div class="row"><div class="large-6 large-centered medium-6 medium-centered small-12 small-centered columns">
                <a href="' . $link . '" class="medium radius button middle centre h6 capitalise">' . $text . '</a>
            </div></div>';
    }
}

function linkButton2($text, $link)
{

    return '<div class="row"><div class="large-6 large-centered medium-6 medium-centered small-12 small-centered columns">
                <a href="' . $link . '" class="medium radius button middle centre h6 capitalise">' . $text . '</a>
            </div></div>';

}

function formEndWithButton($buttonText, $delete = false, $back = false)
{
    if (!$delete && !$back) {
        return '</div>                   
                    <div class="row">
                        <div class="large-8 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <input type="submit" name="btnSubmit" value="' . $buttonText . '" class="button expanded"/>
                             <input class="button expanded" type="reset" value="Reset">
                        </div>
                    </div>
                </div></div>           
            </form>';
    } else if ($back && $delete) {
        return '</div>                   
                    <div class="row">
                        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <input type="submit" name="btnSubmit" value="' . $buttonText . '" class="medium radius button left h6 capitalise"/>
                        </div>
                        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <a href="' . $delete . '" class="medium radius button alert right h6 capitalise">Delete</a> 
                        </div>
                    </div>
                     <div class="row">                                   
                         <div class="large-6 large-centered medium-6 medium-centered small-12 small-centered column">
                            <a href="' . $back . '" class="medium radius button middle centre h6 capitalise">Back</a> 
                        </div>
                                              
         
                    </div>
                </div></div>           
            </form>';
    } else if ($delete) {
        return '</div>                   
                    <div class="row">
                        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <input type="submit" name="btnSubmit" value="' . $buttonText . '" class="medium radius button left h6 capitalise"/>
                        </div>
                        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <a href="' . $delete . '" class="medium radius button alert right h6 capitalise">Delete</a>
                        </div>
                    </div>
                </div></div>           
            </form>';
    } else if ($back) {
        return '</div>                   
                    <div class="row">
                        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <input type="submit" name="btnSubmit" value="' . $buttonText . '" class="medium radius button success left h6 capitalise"/>
                             <input class="button" type="reset" value="Reset">
                        </div>
                                              
                         <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <a href="' . $back . '" class="medium radius button alert right h6 capitalise">Back</a>
                        </div>
                    </div>
                </div></div>           
            </form>';
    }

}

function formEndWithDeleteButton($buttonText)
{
    return '</div>                   
                    <div class="row">
                        <div class="large-4 large-centered medium-6 medium-centered small-12 small-centered columns">
                            <input type="submit" name="btnSubmit" value="' . $buttonText . '" class="medium radius button alert middle h6 capitalise"/>
                        </div>
                    </div>
                </div></div>           
            </form>';
}

function formEnd()
{
    return '</div></div></form>';
}

function textInputBlank($isRequired, $labelDescription, $labelControlName, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function textInputSetup($isRequired, $labelDescription, $labelControlName, $text, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function textInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <input type="text" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <input type="text" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function textInputPostback($isRequired, $labelDescription, $labelControlName, $text, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function textInputPostbackError($isRequired, $labelDescription, $labelControlName, $text, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="text"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <input type="text"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function textareaInputBlank($isRequired, $labelDescription, $labelControlName, $maxLength, $rows, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '" readonly></textarea>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '"></textarea>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '" readonly></textarea>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '"></textarea>
                </label>
            </div>';
        }
    }
}

function textareaInputSetup($isRequired, $labelDescription, $labelControlName, $text, $maxLength, $rows, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '" readonly>' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '">' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            if ($labelDescription == 'Notes') {
                return '<fieldset><legend>Notes</legend>
                    <div class="large-12 medium-12 small-12 columns">
            
                <p>' . $text . '</p>
                </label></fieldset></div>
            </div>';
            } else {

                return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '" readonly>' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
            }
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '">' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
        }
    }
}

function textareaInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $maxLength, $rows)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <textarea class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '"></textarea>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <textarea class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '"></textarea>
                </label>
            </div>';
    }
}

function textareaInputPostback($isRequired, $labelDescription, $labelControlName, $text, $maxLength, $rows)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '">' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <textarea id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '">' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
    }
}

function textareaInputPostbackError($isRequired, $labelDescription, $labelControlName, $text, $errorControlName, $errorMessage, $maxLength, $rows)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <textarea class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '">' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <textarea class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" rows="' . $rows . '" maxlength="' . $maxLength . '">' . htmlspecialchars($text) . '</textarea>
                </label>
            </div>';
    }
}

function passwordInputBlank($isRequired, $labelDescription, $labelControlName, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="password" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="password" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="password" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="password" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function passwordInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <input type="password" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <input type="password" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function numberInputBlank($isRequired, $labelDescription, $labelControlName, $min, $max, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    }
}

function numberInputSetup($isRequired, $labelDescription, $labelControlName, $number, $min, $max, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    }
}

function numberInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $mix, $mac)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <input type="number" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <input type="number" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function numberInputPostback($isRequired, $labelDescription, $labelControlName, $number, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function numberInputPostbackError($isRequired, $labelDescription, $labelControlName, $number, $errorControlName, $errorMessage, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <input type="number"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($number) . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function dateInputBlank($isRequired, $labelDescription, $labelControlName, $min, $max, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    }
}

function dateInputSetup($isRequired, $labelDescription, $labelControlName, $date, $min, $max, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '" disabled/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '" disabled/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    }
}

function dateInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <input type="date" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <input type="date" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function dateInputPostback($isRequired, $labelDescription, $labelControlName, $date, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function dateInputPostbackError($isRequired, $labelDescription, $labelControlName, $date, $errorControlName, $errorMessage, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="date"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <input type="date"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $date . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function emailInputBlank($isRequired, $labelDescription, $labelControlName, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function emailInputSetup($isRequired, $labelDescription, $labelControlName, $email, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '" disabled/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '" disabled/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function emailInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <input type="email" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <input type="email" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function emailInputPostback($isRequired, $labelDescription, $labelControlName, $email, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="email" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function emailInputPostbackError($isRequired, $labelDescription, $labelControlName, $email, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="email"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <input type="email"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($email) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function telInputBlank($isRequired, $labelDescription, $labelControlName, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function telInputSetup($isRequired, $labelDescription, $labelControlName, $tel, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
        }
    }
}

function telInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>                
                <input type="tel" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
         <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>                
                <input type="tel" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function telInputPostback($isRequired, $labelDescription, $labelControlName, $tel, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="tel" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function telInputPostbackError($isRequired, $labelDescription, $labelControlName, $tel, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="tel"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <input type="tel"  class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($tel) . '" maxlength="' . $maxLength . '"/>
                </label>
            </div>';
    }
}

function comboInputBlank($isRequired, $labelDescription, $labelControlName, $text, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">
                <option value="" selected="selected">' . $text . '</option>';
        foreach ($options as $key => $value) {
            if ($labelDescription === "Rank") {
                $output .= '<option value="' . $value . '">' . $value . '</option>';
            } else {
                $output .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $output .= '</select>
                </label>
            </div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">
                <option value="" selected="selected">' . $text . '</option>';
        foreach ($options as $key => $value) {
            if ($labelDescription === "Rank") {
                $output .= '<option value="' . $value . '">' . $value . '</option>';
            } else {
                $output .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $output .= '</select>
                </label>
            </div>';
        return $output;
    }
}

function comboInputEmptyError($isRequired, $labelDescription, $labelControlName, $text, $errorControlName, $errorMessage, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '">
                <option value="" selected="selected">' . $text . '</option>';
        foreach ($options as $key => $value) {
            $output .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $output .= '</select>
                </label>
            </div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label><b>' . $labelDescription . '</b>
                <select class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '">
                <option value="" selected="selected">' . $text . '</option>';
        foreach ($options as $key => $value) {
            $output .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $output .= '</select>
                </label>
            </div>';
        return $output;
    }
}

function comboInputPostback($isRequired, $labelDescription, $labelControlName, $selected, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">';
        foreach ($options as $key => $value) {
            if ($labelDescription === "Rank") {
                if ($value == $selected) {
                    $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                } else {
                    $output .= '<option value="' . $value . '">' . $value . '</option>';
                }
            }
            if ($key == $selected) {
                $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
            } else {
                $output .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $output .= '</select>
                </label>
            </div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">';
        foreach ($options as $key => $value) {
            if ($labelDescription === "Rank") {
                if ($value == $selected) {
                    $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                } else {
                    $output .= '<option value="' . $value . '">' . $value . '</option>';
                }
            }
            if ($key == $selected) {
                $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
            } else {
                $output .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $output .= '</select>
                </label>
            </div>';
        return $output;
    }
}

function comboInputSetup($isRequired, $labelDescription, $labelControlName, $selected, $options, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '" disabled>';
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">';

            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        }
    } else {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '" disabled>';
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">';
            if ($labelDescription === "Squad") {
                $output .= '<option value="" selected="selected">No Squad</option>;';
            }
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        }
    }
}

function checkboxInputBlank($isRequired, $labelDescription, $labelControlName, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }

        $output .= '</div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }

        $output .= '</div>';
        return $output;
    }
}

function checkboxInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>
                <div class="errinput">';
        foreach ($options as $key => $value) {
            $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }

        $output .= '</div></div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
        <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }

        $output .= '</div>';
        return $output;
    }
}

function checkboxInputSetup($isRequired, $labelDescription, $labelControlName, $selected, $options, $isReadOnly = false)
{
    $array = array();
    foreach ($selected as $key => $value) {
        array_push($array, $value);
    }
    if ($isRequired) {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns disabled">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if (in_array($key, $array)) {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" checked disabled><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" disabled><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if (in_array($key, $array)) {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        }
    } else {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns disabled">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if (in_array($key, $array)) {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" checked disabled><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" disabled><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if (in_array($key, $array)) {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        }

    }
}

function listMemberRoles($selected, $options)
{
    $array = array();
    foreach ($selected as $key => $value) {
        array_push($array, $value);
    }
    $output = "";

    foreach ($options as $key => $value) {
        if (in_array($key, $array)) {
            $output .= $value . ",";
        }
    }
    return $output;
}

function checkboxInputPostback($isRequired, $labelDescription, $labelControlName, $selected, $options)
{
    $array = array();
    foreach ($selected as $key => $value) {
        array_push($array, $value);
    }

    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            if (in_array($key, $array)) {
                $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
            } else {
                $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
            }
        }
        $output .= '</div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            if (in_array($key, $array)) {
                $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
            } else {
                $output .= '<input type="checkbox" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
            }
        }
        $output .= '</div>';
        return $output;
    }
}

function moneyInputBlank($isRequired, $labelDescription, $labelControlName, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>
                <span class="required">* </span>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
            </div>
            </div>
        </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
            </div>
            </div>
        </div>';
    }
}

function moneyInputSetup($isRequired, $labelDescription, $labelControlName, $text, $maxLength, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>
                <span class="required">* </span>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" value="' . $text . '" readonly/>
            </div>
            </div>
        </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>
                <span class="required">* </span>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" value="' . $text . '"/>
            </div>
            </div>
        </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
        <span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" value="' . $text . '"  readonly/>
            </div>
            </div>
        </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
        <span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" value="' . $text . '"/>
            </div>
            </div>
        </div>';
        }
    }
}

function moneyInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
            <label for="' . $labelControlName . '"><b>
                <span class="required">* </span>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
            </div>
            </div>
        </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
            <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '"/>
            </div>
            </div>
        </div>';
    }
}

function moneyInputPostback($isRequired, $labelDescription, $labelControlName, $text, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>
                <span class="required">* </span>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" value="' . $text . '"/>
            </div>
            </div>
        </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
            <div class="row collapse">
            <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b></label>
            <div class="small-1 columns">
		<span class="prefix">£</span>
            </div>
            <div class="small-11 columns">
                <input type="text" id="' . $labelControlName . '" name="' . $labelControlName . '" maxlength="' . $maxLength . '" value="' . $text . '"/>
            </div>
            </div>
        </div>';
    }
}

function moneyInputPostbackError($isRequired, $labelDescription, $labelControlName, $text, $errorControlName, $errorMessage, $maxLength)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <div class="row collapse">
                <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label for="' . $labelControlName . '"><b><span class="required">* </span>' . $labelDescription . '</b></label>
                <div class="small-1 columns">
                    <span class="prefix">£</span>
                </div>
                <div class="small-11 columns">
                    <input type="text" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </div>
            </div></div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <div class="row collapse">
                <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b></label>
                <div class="small-1 columns">
                    <span class="prefix">£</span>
                </div>
                <div class="small-11 columns">
                    <input type="text" class="errinput" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . htmlspecialchars($text) . '" maxlength="' . $maxLength . '"/>
                </div>
            </div></div>';
    }
}

function numInputBlank($isRequired, $labelDescription, $labelControlName, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function numInputPostback($isRequired, $labelDescription, $labelControlName, $value, $min, $max)
{
    if ($isRequired) {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $value . '"  min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    } else {
        return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $value . '"  min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
    }
}

function numInputSetup($isRequired, $labelDescription, $labelControlName, $value, $min, $max, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $value . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $value . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    } else {
        if ($isReadOnly) {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $value . '" min="' . $min . '" max="' . $max . '" readonly/>
                </label>
            </div>';
        } else {
            return '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <input type="number" id="' . $labelControlName . '" name="' . $labelControlName . '" value="' . $value . '" min="' . $min . '" max="' . $max . '"/>
                </label>
            </div>';
        }
    }
}

function radioInputBlank($isRequired, $labelDescription, $labelControlName, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '"><b>
                <span class="required">* </span>' . $labelDescription . '</b>
            </label>';
        foreach ($options as $key => $value) {
            $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }
        $output .= '</div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
            </label>';
        foreach ($options as $key => $value) {
            $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }
        $output .= '</div>';
        return $output;
    }
}

function radioInputEmptyError($isRequired, $labelDescription, $labelControlName, $errorControlName, $errorMessage, $options)
{
    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
            <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>
                <div class="errinput">';
        foreach ($options as $key => $value) {
            $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }

        $output .= '</div></div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
        <label for="' . $labelControlName . '" id="' . $errorControlName . '" class="errlabel">' . $errorMessage . '</label>
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
        }

        $output .= '</div>';
        return $output;
    }
}

function radioInputSetup($isRequired, $labelDescription, $labelControlName, $selected, $options, $isReadOnly = false)
{

    if ($isRequired) {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns disabled">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if ($key == $selected) {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if ($key == $selected) {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        }
    } else {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns disabled">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if ($key == $selected) {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
            foreach ($options as $key => $value) {
                if ($key == $selected) {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
                } else {
                    $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
                }
            }
            $output .= '</div>';
            return $output;
        }

    }
}

function radioInputPostback($isRequired, $labelDescription, $labelControlName, $selected, $options)
{
    if (!empty($selected)) {
        foreach ($selected as $key => $value) {
            $input = $value;
        }
    } else {
        $input = null;
    }

    if ($isRequired) {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            if ($key === $input) {
                $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
            } else {
                $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
            }
        }
        $output .= '</div>';
        return $output;
    } else {
        $output = '<div class="large-12 medium-12 small-12 columns">
                <label for="' . $labelControlName . '"><b>' . $labelDescription . '</b>
                </label>';
        foreach ($options as $key => $value) {
            if ($key === $input) {
                $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '" checked><label for="' . $labelControlName . '">' . $value . '</label>';
            } else {
                $output .= '<input type="radio" name="' . $labelControlName . '[]" value="' . $key . '"><label for="' . $labelControlName . '">' . $value . '</label>';
            }
        }
        $output .= '</div>';
        return $output;
    }
}

?>