   <?php
if($logged)
{
    // type (1 = question; 2 = answer)
    // status (1 = open; 2 = new message; 3 = closed;)
    
    $dark = $config['site']['darkborder'];
    $light = $config['site']['lightborder'];
    
    $priority = array(1 => "Baixa", "Normal", "Alta");
    $tags = array(1 => "[Vendas]", "[Suporte]", "[Parceria]", "[Bug]", "[Outros]");
        
    if($group_id_of_acc_logged >= $config['site']['access_admin_panel'] and $_REQUEST['control'] == "true")
    {
        if(empty($_REQUEST['id']) and empty($_REQUEST['acc']) or !is_numeric($_REQUEST['acc']) or !is_numeric($_REQUEST['id']) )
            $bug[1] = $SQL->query('SELECT * FROM '.$SQL->tableName('z_helpdesk').' where `type` = 1 order by `uid` desc');
        
        if(!empty($_REQUEST['id']) and is_numeric($_REQUEST['id']) and !empty($_REQUEST['acc']) and is_numeric($_REQUEST['acc']))
            $bug[2] = $SQL->query('SELECT * FROM '.$SQL->tableName('z_helpdesk').' where `account` = '.$_REQUEST['acc'].' and `id` = '.$_REQUEST['id'].' and `type` = 1')->fetch();
        
        if(!empty($_REQUEST['id']) and is_numeric($_REQUEST['id']) and !empty($_REQUEST['acc']) and is_numeric($_REQUEST['acc']))
        {
            if(!empty($_REQUEST['reply']))
                $reply=true;
                
             $account = new Account;
            $account->load($_REQUEST['acc']);
            $account->isLoaded();
            $players = $account->getPlayersList();
            
            if(!$reply)
            {
                if($bug[2]['status'] == 2)
                    $value = "<font color=gray><b>Aguardando</b> <img src=images/bug/waiting.gif></font>";
                elseif($bug[2]['status'] == 4)
                    $value = "<font color=green><b>Respondido</b></font> <img src=images/bug/ok.png>";
                elseif($bug[2]['status'] == 3)
                    $value = "<font color=red><b>Fechado</b></font> <img src=images/bug/closed.png>";
                elseif($bug[2]['status'] == 1)
                    $value = "<font color=#4169E1><b>Nova Resposta</b></font> <img src=images/bug/new.png>";
                    
                $main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=2 CLASS=white><B>Atendimento</B></TD></TR>';                            
                $main_content .= '<TR BGCOLOR="'.$dark.'"><td width=40%><img src=images/bug/report.png> <b>Assunto:</b></td><td> '.$tags[$bug[2]['tag']].' '.$bug[2]['subject'].'  '.$value.'</td></tr>';
                $main_content .= '<TR BGCOLOR="'.$light.'"><td><img src=images/bug/pri.gif> <b>Prioridade:</b></td><td> <img src=images/bug/'.$bug[2]['priority'].'.png> '.$priority[$bug[2]['priority']].'';
                $main_content .= '<TR BGCOLOR="'.$dark.'"><td><img src=images/bug/tibia.png> <b>Enviado por:</b></td><td>';
                
                
                foreach($players as $player)
                {
                    $main_content .= '<img src=images/bug/t.png> '.$player->getName().'<br>';
                }
                
                $main_content .= '</td></tr>';
                $main_content .= '<TR BGCOLOR="'.$light.'"><td colspan=2><img src=images/bug/des.png><b>Menssagem: '.nl2br($bug[2]['text']).'</td></tr>';    
                $main_content .= '</TABLE>';
                
                $answers = $SQL->query('SELECT * FROM '.$SQL->tableName('z_helpdesk').' where `account` = '.$_REQUEST['acc'].' and `id` = '.$_REQUEST['id'].' and `type` = 2 order by `reply`');
                
                $ot = $config['site']['worlds'];
                
                foreach($answers as $answer)
                {
                    if($answer['who'] == 1)
                        $who = "<img src=layouts/tibiacom/images/group.png> <font color=red><b>Staff</b></font>";
                    else
                        $who = "<img src=images/bug/staff.gif> <font color=green><b>Player</b></font>";
                        
                    $main_content .= '<br><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=2 CLASS=white><B>Resposta #'.$answer['reply'].'</B></TD></TR>';                            
                    $main_content .= '<TR BGCOLOR="'.$dark.'"><td width=40%><img src=images/bug/tibia.png><i><b>Enviado por:</b></i></td><td>'.$who.'</td></tr>';
                $main_content .= '<TR BGCOLOR="'.$light.'"><td colspan=2><img src=images/bug/des.png><b>Resposta: '.nl2br($answer['text']).'</b></td></tr>';
                $main_content .= '</TABLE>';
                }
                if($bug[2]['status'] <= 4)
                    $main_content .= '<br><a href="index.php?subtopic=helpdesk&control=true&id='.$_REQUEST['id'].'&acc='.$_REQUEST['acc'].'&reply=true"><b>[Responder]</b></a>';
            }
            else
            {
                //if($bug[2]['status'] < 3)
                //{
                    $reply = $SQL->query('SELECT MAX(reply) FROM `z_helpdesk` where `account` = '.$_REQUEST['acc'].' and `id` = '.$_REQUEST['id'].' and `type` = 2')->fetch();
                    $reply = $reply[0] + 1;
                    $iswho = $SQL->query('SELECT * FROM `z_helpdesk` where `account` = '.$_REQUEST['acc'].' and `id` = '.$_REQUEST['id'].' and `type` = 2 order by `reply` desc limit 1')->fetch();

                    if(isset($_POST['finish']))
                    {
                        if(empty($_POST['text']))
                            $error[] = "<font color=black><b>Por favor, preencha a Descricao.</b></font>";
                        //if($iswho['who'] == 1)
                            //$error[] = "<font color=black><b>Você precisa aguardar a resposta do usuário.</b></font>";
                        if(empty($_POST['status']))
                            $error[] = "<font color=black><b>Status cannot be empty.</b></font>";
                            
                            
                        if(!empty($error))
                        {
                            foreach($error as $errors)
                                $main_content .= ''.$errors.'<br>';
                        }
                        else
                        {
                            $type = 2;
                            $INSERT = $SQL->query('INSERT INTO `z_helpdesk` (`account`,`id`,`text`,`reply`,`type`, `who`) VALUES ('.$SQL->quote($_REQUEST['acc']).','.$SQL->quote($_REQUEST['id']).','.$SQL->quote($_POST['text']).','.$SQL->quote($reply).','.$SQL->quote($type).','.$SQL->quote(1).')');
                            $UPDATE = $SQL->query('UPDATE `z_helpdesk` SET `status` = '.$_POST['status'].' where `account` = '.$_REQUEST['acc'].' and `id` = '.$_REQUEST['id'].'');
                            header('Location: index.php?subtopic=helpdesk&control=true&id='.$_REQUEST['id'].'&acc='.$_REQUEST['acc'].'');
                        }
                    }
                    $main_content .= '<br><form method="post" action=""><table><tr><td>Mensagem:</i></td><td><textarea name="text" rows="3" cols="25"></textarea></td></tr><tr><td><br><font color=gray><b>Aguardando</b></font> <img src=images/bug/waiting.gif></td><td><input type=radio name=status value=2></td></tr><tr><td><font color=green><b>Respondido  <img src=images/bug/ok.png /></b></font></td><td><input type=radio name=status value=4></td></tr><tr><td><font color=red><b>Fechado <img src=images/bug/closed.png></b></font></td><td><input type=radio name=status value=3></td></tr></table><br><input type="submit" name="finish" value="Submit" class="input2"/></form>';
                //}
                //else
                //{
                    //$main_content .= "<br><font color=black><b>You can't add answer to closed bug thread.</b></font>";
                //}
            }
            
            $post=true;
        }
        if(!$post)
        {
            $main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD colspan=2 CLASS=white><B>Atendimento Admin</B></TD></TR>';            
            $i=1;
            foreach($bug[1] as $report)
            {
            
              
                if($report['status'] == 2)
                    $value = "<font color=gray><b>Aguardando</b> <img src=images/bug/waiting.gif></font>";
                elseif($report['status'] == 3)
                    $value = "<font color=red><b>Fechado</b></font> <img src=images/bug/closed.png>";
                elseif($report['status'] == 4)
                    $value = "<font color=green><b>Respondido </b></font> <img src=images/bug/ok.png>";
                elseif($report['status'] == 1)
                    $value = "<font color=#4169E1><b>Nova Resposta</b></font> <img src=images/bug/new.png>";
                            
                if(is_int($i / 2))
                {
                    $bgcolor = $dark;
                }
                else
                {
                    $bgcolor = $light;
                }

                $main_content .= '<TR BGCOLOR="'.$bgcolor.'"><td width=75%><img src=images/bug/'.$report['priority'].'.png> <a href="index.php?subtopic=helpdesk&control=true&id='.$report['id'].'&acc='.$report['account'].'">'.$tags[$report['tag']].' '.$report['subject'].'</a></td><td>'.$value.'</td></tr>';
                        
                $showed=true;
                $i++;
            }
            $main_content .= '</TABLE>';
        }
    }
    else
    {        
        $acc = $account_logged->getId();
        $account_players = $account_logged->getPlayersList();
        
        foreach($account_players as $player)
        {
            $allow=true;
        }
        
        if(!empty($_REQUEST['id']))
            $id = addslashes(htmlspecialchars(trim($_REQUEST['id'])));
        
        if(empty($_REQUEST['id']))
            $bug[1] = $SQL->query('SELECT * FROM '.$SQL->tableName('z_helpdesk').' where `account` = '.$account_logged->getId().' and `type` = 1 order by `id` desc');
        
        if(!empty($_REQUEST['id']) and is_numeric($_REQUEST['id']))
            $bug[2] = $SQL->query('SELECT * FROM '.$SQL->tableName('z_helpdesk').' where `account` = '.$account_logged->getId().' and `id` = '.$id.' and `type` = 1')->fetch();
        else
            $bug[2] = NULL;
            
        if(!empty($_REQUEST['id']) and $bug[2] != NULL)
        {
            if(!empty($_REQUEST['reply']))
                $reply=true;
            
            if(!$reply)
            {
            

                if($bug[2]['status'] == 1)
                    $value = "<font color=gray><b>Aguardando</b> <img src=images/bug/waiting.gif></font>";
                elseif($bug[2]['status'] == 2)
                    $value = "<font color=#4169E1><b>Nova Resposta</b></font> <img src=images/bug/new.png>";
                elseif($bug[2]['status'] == 3)
                    $value = "<font color=red><b>Fechado</b></font> <img src=images/bug/closed.png>";
                elseif($bug[2]['status'] == 4)     
                    $value = "<font color=green><b>Respondido</b></font> <img src=images/bug/ok.png>";

                    
                $main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=2 CLASS=white><B>Atendimento</B></TD></TR>';                            
                $main_content .= '<TR BGCOLOR="'.$dark.'"><td width=40%><img src=images/bug/report.png><b> Assunto:</b></td><td> '.$tags[$bug[2]['tag']].' '.$bug[2]['subject'].' '.$value.'</td></tr>';
                $main_content .= '<TR BGCOLOR="'.$light.'"><td><img src=images/bug/pri.gif> <b>Prioridade:</b></td><td> <img src=images/bug/'.$bug[2]['priority'].'.png> '.$priority[$bug[2]['priority']].'';
                
                $main_content .= '<TR BGCOLOR="'.$dark.'"><td><img src=images/bug/tibia.png> <b>Enviado por:</b></td><td>';
                $main_content .= '<img src=images/bug/t.png> You <br>';
            
                  
                $main_content .= '<TR BGCOLOR="'.$light.'"><td colspan=2><img src=images/bug/des.png><b>Mensagem: '.nl2br($bug[2]['text']).'</b></td></tr>';
                $main_content .= '</TABLE>';
                
                $answers = $SQL->query('SELECT * FROM '.$SQL->tableName('z_helpdesk').' where `account` = '.$account_logged->getId().' and `id` = '.$id.' and `type` = 2 order by `reply`');
                foreach($answers as $answer)
                {
                    if($answer['who'] == 1)
                        $who = "<img src=layouts/tibiacom/images/group.png> <font color=red><b>Staff</b></font>";
                    else
                        $who = "<img src=images/bug/staff.gif> <font color=green><b>YOU</b></font>";
                        
                    $main_content .= '<br><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD COLSPAN=2 CLASS=white><B>Resposta #'.$answer['reply'].'</B></TD></TR>';                            
                    $main_content .= '<TR BGCOLOR="'.$dark.'"><td width=40%><img src=images/bug/tibia.png><i><b> Enviado por:</b></i></td><td>'.$who.'</td></tr>';
                    $main_content .= '<TR BGCOLOR="'.$light.'"><td colspan=2><img src=images/bug/des.png><b>Resposta: '.nl2br($answer['text']).'</b></td></tr>';
                    $main_content .= '</TABLE>';
                }
                if($bug[2]['status'] != 3)
                    $main_content .= '<br><a href="index.php?subtopic=helpdesk&id='.$id.'&reply=true"><b>[Responder]</b></a>';
            }
            else
            {
                //if($bug[2]['status'] != 3)
                //{
                    $reply = $SQL->query('SELECT MAX(reply) FROM `z_helpdesk` where `account` = '.$acc.' and `id` = '.$id.' and `type` = 2')->fetch();
                    $reply = $reply[0] + 1;
                    $iswho = $SQL->query('SELECT * FROM `z_helpdesk` where `account` = '.$acc.' and `id` = '.$id.' and `type` = 2 order by `reply` desc limit 1')->fetch();

                    if(isset($_POST['finish']))
                    {
                        if(empty($_POST['text']))
                            $error[] = "<font color=black><b>Descricao não pode ser vazia.</b></font>";
                        if($iswho['who'] == 0)
                            $error[] = "<font color=black><b>Você precisa aguardar a resposta da staff.</b></font>";
                        if(!$allow)
                            $error[] = "<font color=black><b>Você não possui nenhum char na conta.</b></font>";
                            
                        if(!empty($error))
                        {
                            foreach($error as $errors)
                                $main_content .= ''.$errors.'<br>';
                        }
                        else
                        {
                            $type = 2;
                            $INSERT = $SQL->query('INSERT INTO `z_helpdesk` (`account`,`id`,`text`,`reply`,`type`) VALUES ('.$SQL->quote($acc).','.$SQL->quote($id).','.$SQL->quote($_POST['text']).','.$SQL->quote($reply).','.$SQL->quote($type).')');
                            $UPDATE = $SQL->query('UPDATE `z_helpdesk` SET `status` = 1 where `account` = '.$acc.' and `id` = '.$id.'');
                            header('Location: index.php?subtopic=helpdesk&id='.$id.'');
                        }
                    }
                    $main_content .= '<br><form method="post" action=""><table><tr><td><i>Description</i></td><td><textarea name="text" rows="15" cols="35"></textarea></td></tr></table><br><input type="submit" name="finish" value="Submit" class="input2"/></form>';
                //}
                //else
//
                    //$main_content .= "<br><font color=black><b>You can't add answer to closed bug thread.</b></font>";
                //}
            }
            
            $post=true;
        }
        elseif(!empty($_REQUEST['id']) and $bug[2] == NULL)
        {
            $main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD CLASS=white><B>Atendimento</B></TD></TR>';                            
            $main_content .= '<TR BGCOLOR="'.$dark.'"><td><i>Ticket doesn\'t exist.</i></td></tr>';    
            $main_content .= '</TABLE>';
            $post=true;
        }
        
        if(!$post)
        {
            if($_REQUEST['add'] != TRUE)
            {
                $main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><TR BGCOLOR='.$config['site']['vdarkborder'].'><TD colspan=2 CLASS=white><B>Atendimento</B></TD></TR>';            
                foreach($bug[1] as $report)
                {
                    if($report['status'] == 1)
                    $value = "<font color=gray><b>Aguardando</b> <img src=images/bug/waiting.gif></font>";
                    elseif($report['status'] == 2)
                    $value = "<font color=#4169E1><b>Nova Resposta</b></font> <img src=images/bug/new.png>";
                    elseif($report['status'] == 3)
                    $value = "<font color=red><b>Fechado</b></font> <img src=images/bug/closed.png>";
                    elseif($report['status'] == 4)                    
                    $value = "<font color=green><b>Respondido </b></font> <img src=images/bug/ok.png>";
                        
                    if(is_int($report['id'] / 2))
                    {
                        $bgcolor = $dark;
                    }
                    else
                    {
                        $bgcolor = $light;
                    }

                    $main_content .= '<TR BGCOLOR="'.$bgcolor.'"><td width=75%><img src=images/bug/'.$report['priority'].'.png> <a href="index.php?subtopic=helpdesk&id='.$report['id'].'">'.$tags[$report['tag']].' '.$report['subject'].'</a></td><td>'.$value.'</td></tr>';
                    
                    $showed=true;
                }
                
                if(!$showed)
                {
                    $main_content .= '<TR BGCOLOR="'.$dark.'"><td><i>Nenhum atendimento solicitado. Precisa de ajuda ou entrar em contato com a equipe do Relembra Global?</i></td></tr>';    
                }
                $main_content .= '</TABLE>';
                
                $main_content .= '<br><a href="index.php?subtopic=helpdesk&add=true"><b>[Abrir Chamado]</b></a>';
            }
            elseif($_REQUEST['add'] == TRUE)
            {
                $thread = $SQL->query('SELECT * FROM `z_helpdesk` where `account` = '.$acc.' and `type` = 1 order by `id` desc')->fetch();
                $id_next = $SQL->query('SELECT MAX(id) FROM `z_helpdesk` where `account` = '.$acc.' and `type` = 1')->fetch();
                $id_next = $id_next[0] + 1;
                
                if(empty($thread))
                    $thread['status'] = 3;
                    
                if(isset($_POST['submit']))
                {
                    //if($thread['status'] != 3)
                        //$error[] = "<font color=black><b>Can be only 1 open bug thread.</b></font>";
                    if(empty($_POST['subject']))
                        $error[] = "<font color=black><b>Assunto cannot be empty.</b></font>";
                    if(empty($_POST['text']))
                        $error[] = "<font color=black><b>Description cannot be empty.</b></font>";
                    if(!$allow)
                        $error[] = "<font color=black><b>You haven't any characters on account.</b></font>";
                    if(empty($_POST['tags']))
                        $error[] = "<font color=black><b>Tag cannot be empty.</b></font>";
                        
                    if(!empty($error))
                    {
                        foreach($error as $errors)
                            $main_content .= ''.$errors.'<br>';
                    }
                    else
                    {
                        $type = 1;
                        $status = 1;
                        $INSERT = $SQL->query('INSERT INTO `z_helpdesk` (`account`,`id`,`text`,`type`,`subject`,`status`,`tag`,`priority`) VALUES ('.$SQL->quote($acc).','.$SQL->quote($id_next).','.$SQL->quote($_POST['text']).','.$SQL->quote($type).','.$SQL->quote($_POST['subject']).','.$SQL->quote($status).','.$SQL->quote($_POST['tags']).','.$SQL->quote($_POST['priority']).')');
                        header('Location: index.php?subtopic=helpdesk&id='.$id_next.'');
                    }
                        
                }
                $main_content .= '<br><form method="post" action=""><font size=4><b>Atendimento</b></font><br><br><br><table><tr><td><img src=images/bug/report.png> <b>Assunto:</b></td><td><input type=text name="subject"/></td></tr><tr><td><img src=images/bug/des.png><b>Descricao:</b></td><td><textarea name="text" rows="4" cols="15"></textarea></td></tr><tr><td><img src=images/bug/tag.png> <b>TAG:</b></td><td><select name="tags"><option value="">SELECT</option>';
                
                for($i = 1; $i <= count($tags); $i++)
                {
                    $main_content .= '<option value="' . $i . '">' . $tags[$i] . '</option>';
                }
                
               $main_content .= '</td></tr><tr><td><br><img src=images/bug/pri.gif> <b>Prioridade:</b></td><td><br><select name="priority"><option value="">SELECT</option>';
                
                for($i = 1; $i <= count($priority); $i++)
                {
                    $main_content .= '<option value="' . $i . '">' . $priority[$i] . '</option>';
                }
               
                
                $main_content .= '</select></tr></tr></table><br><input type="submit" name="submit" value="Submit" class="input2"/></form>';
            }
        }
    }
    
    if($group_id_of_acc_logged >= $config['site']['access_admin_panel'] and empty($_REQUEST['control']))
    {
        $main_content .= '<br><br><a href="index.php?subtopic=helpdesk&control=true">[ADMIN PANEL]</a>';
    }
}
else
{
    $main_content .= 'Please enter your account name and your password.<br/><a href="?subtopic=createaccount" >Create an account</a> if you do not have one yet.<br/><br/><form action="?subtopic=helpdesk" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Login</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Account Name:</span></td><td style="width:100%;" ><input type="password" name="account_login" SIZE="10" maxlength="10" ></td></tr><tr><td class="LabelV" ><span >Password:</span></td><td><input type="password" name="password_login" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table width="100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=lostaccount" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Account lost?" alt="Account lost?" src="'.$layout_name.'/images/buttons/_sbutton_accountlost.gif" ></div></div></td></tr></form></table></td></tr></table>';
}
?> 