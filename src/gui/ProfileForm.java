package gui;

import com.codename1.components.ScaleImageLabel;
import com.codename1.ui.Button;
import com.codename1.ui.CheckBox;
import com.codename1.ui.Component;
import com.codename1.ui.Display;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.GridLayout;
import com.codename1.ui.layouts.LayeredLayout;
import com.codename1.ui.plaf.Style;
import com.codename1.ui.util.Resources;

public class ProfileForm extends BaseForm {

    private Resources theme;

    public ProfileForm() {
        super("Profile Space", BoxLayout.y());
        Toolbar tb = new Toolbar(true);
        setToolbar(tb);
        getTitleArea().setUIID("Container");
        setTitle("Profile");
        getContentPane().setScrollVisible(false);

        //  super.addSideMenu(theme);
        tb.addSearchCommand(e -> {
        });

        Label username = new Label(SessionManager.getUserName());
        username.setUIID("TextFieldBlack");
        addStringValue("Nom :", username);

        Label prenom = new Label(SessionManager.getPrenom());
        username.setUIID("TextFieldBlack");
        addStringValue("Prenom", prenom);

        Label adresse = new Label(SessionManager.getEmail());
        username.setUIID("TextFieldBlack");
        addStringValue("E-mail", adresse);
 
        
        Button btnghayth = new Button("Reservation Space");
            btnghayth.addActionListener(e-> new gui.HomeForm(this).show());
          add(btnghayth);
            Button signIn = new Button("Logout");
        
       signIn.addActionListener(e -> new SignInForm().show());
        add(signIn);
    }

    private void addStringValue(String s, Component v) {
        add(BorderLayout.west(new Label(s, "PaddedLabel")).
                add(BorderLayout.CENTER, v));
        add(createLineSeparator(0xeeeeee));
    }
}
