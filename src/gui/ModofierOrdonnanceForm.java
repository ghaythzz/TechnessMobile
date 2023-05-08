/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.ui.Form;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceOrdonnance;
import com.codename1.messaging.Message;
import com.codename1.ui.Display;
import com.mycompany.myapp.services.ServiceUtilisateur;
//import javax.mail.*;
//import javax.mail.internet.InternetAddress;
//import javax.mail.internet.MimeMessage;





/**
 *
 * @author asus
 */
public class ModofierOrdonnanceForm extends Form {

    String email;

    public ModofierOrdonnanceForm(Form previous, Ordonnance o) {
        setTitle("Add a new Ordonnance");
        setLayout(BoxLayout.y());

        TextField com = new TextField("", "commentaire");
        Button btnValider = new Button("update Ordonnance");
        btnValider.addActionListener(new ActionListener() {
            public void actionPerformed(ActionEvent evt) {
                Ordonnance t = new Ordonnance(com.getText().toString());
                email = ServiceOrdonnance.getInstance().getPatientEmail(o.getPatient_id());
                System.out.println(email);
                if (ServiceOrdonnance.getInstance().modifierOrdonnance(t, o.getId())) {
                    String subject = "Ordonnance Update";
                    String body = "Your Ordonnance has been updated";
                    Message m = new Message("Your Ordonnance has been updated");
                    m.setMimeType(Message.MIME_TEXT);
                    Display.getInstance().sendMessage(new String[]{email}, "updateOrdonnance", m);
                    Dialog.show("Success", "Connection accepted", new Command("OK"));
                     ListOrdonnanceForm listOrdonnanceForm = new ListOrdonnanceForm(previous);
                    listOrdonnanceForm.show();
                } else {
                    Dialog.show("ERROR", "Server error", new Command("OK"));
                }
            }

        });
        addAll(com, btnValider);
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
    }

}
