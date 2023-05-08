/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.TextField;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceOrdonnance;

/**
 *
 * @author asus
 */
public class OrdonnanceMedicamentForm extends Form{
    public OrdonnanceMedicamentForm(Form previous){
    TextField med = new TextField("", "Medicament");
    TextField dur = new TextField("", "Duration");
    TextField dos = new TextField("", "Dosage");
    Button enr = new Button("Enregistrer");
    Button medic = new Button("Ajouter Medicament ");
    
    setTitle("Add Medicament");
    setLayout(BoxLayout.y());
    
    /* medic.addActionListener(new ActionListener() {
       public void actionPerformed(ActionEvent evt) {
            if (ServiceOrdonnance.getInstance().addOrdonnance(t, 1)) {
                Dialog.show("Success", "Connection accepted", new Command("OK"));
            } else {
                Dialog.show("ERROR", "Server error", new Command("OK"));
            }
        }
    });*/
    
    addAll(med,dur,dos, enr, medic);
    getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
                
    
    }
}
