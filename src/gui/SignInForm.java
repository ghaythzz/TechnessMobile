package gui;

import com.codename1.components.FloatingHint;
import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Display;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.mycompany.myapp.services.ServiceUtilisateur;


public class SignInForm extends Form {

    public SignInForm() {
        super(new BorderLayout());
 setUIID("SignIn");        
//        add(BorderLayout.NORTH, new Label(res.getImage("Logo.png"), "LogoLabel"));       
        TextField username = new TextField("", "email", 20, TextField.ANY);
        TextField password = new TextField("", "Password", 20, TextField.PASSWORD);
     
        Button signIn = new Button("Sign In");
        Button signUp = new Button("Sign Up");
        
        //mp oublié
        Button  mp = new Button("oublier mot de passe?");
               
        signUp.addActionListener(e -> new SignUpForm().show());
        signUp.setUIID("Link");
        Label dontHaveAnAccount = new Label("Vous n'avez aucune compte?");

        Container content = BoxLayout.encloseY(
                new FloatingHint(username),
                new FloatingHint(password),
                
                signIn,
                FlowLayout.encloseCenter(dontHaveAnAccount, signUp));
      
        content.setScrollableY(true);
     add(BorderLayout.SOUTH, content);
       // signIn.requestFocus();
        
        signIn.addActionListener(e -> {ServiceUtilisateur.getInstance().signin(username, password, null);});
       
        //Mp oublie event
        //mp.addActionListener((e) -> {
          // new ActivateForm().show();  
      // });        
    }    
}
