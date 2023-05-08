/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.ui.Button;
import com.codename1.ui.ComboBox;
import com.codename1.ui.Command;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.RadioButton;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.spinner.Picker;
import com.mycomany.entities.Fiche;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceFiche;
import com.mycompany.myapp.services.ServiceOrdonnance;

/**
 *
 * @author asus
 */
public class ModifierFicheForm extends Form {
    public ModifierFicheForm(Form previous,int id,Fiche f){
       setTitle("Modifier fiche");
setLayout(new BorderLayout());

        Container center = new Container(new BoxLayout(BoxLayout.Y_AXIS));
center.setScrollableY(true);
add(BorderLayout.CENTER, center);

Label phoneLabel = new Label("Phone number");
TextField phoneField = new TextField(Integer.toString(f.getTel()), "tel", 8, TextField.NUMERIC);
phoneField.setUIID("TextField");

Label typeLabel = new Label("Insurance type");
TextField typeField = new TextField(f.getTypeAssurance(), "type_assurance");
typeField.setUIID("TextField");

Label etatLabel = new Label("Etat Clinique");
ComboBox<String> etatComboBox = new ComboBox<>(f.getEtatClinique());
etatComboBox.addItem("Bon");
etatComboBox.addItem("Moyen");
etatComboBox.addItem("Mauvais");

        Label genreLabel = new Label("Gender");
ComboBox<String> genreComboBox = new ComboBox<>(f.getGenre());
genreComboBox.addItem("Homme");
genreComboBox.addItem("Femme");

Button btnValider = new Button("Update Fiche");
btnValider.addActionListener(new ActionListener() {
    public void actionPerformed(ActionEvent evt) {
        if ((phoneField.getText().length()!=8)){
            Dialog.show("Alert", "Phone number must be 8 digits", new Command("OK"));
        } else {
            Fiche t = new Fiche(Integer.valueOf(phoneField.getText().toString()),etatComboBox.getSelectedItem().toString(),genreComboBox.getSelectedItem().toString(),typeField.getText().toString());
            if( ServiceFiche.getInstance().modifierFiche(t, id)) {
                Dialog.show("Success","Fiche updated",new Command("OK"));
                ListPatientForm listOrdonnanceForm = new ListPatientForm(previous);
                    listOrdonnanceForm.show();
            } else {
                Dialog.show("ERROR", "Server error", new Command("OK"));
            }
        }
    }
});

center.addAll(phoneLabel, phoneField, typeLabel, typeField, etatLabel, etatComboBox, genreLabel, genreComboBox, btnValider);

getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e-> previous.showBack());
    }
}
