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
import com.codename1.ui.Toolbar;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.GridLayout;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceOrdonnance;

/**
 *
 * @author asus
 */
public class addOrdonnanceForm extends Form {
    public addOrdonnanceForm(Form previous,int id){
    TextField com = new TextField("", "commentaire");
    Button medic = new Button("Add medicament");
    Button btnValider = new Button("Add Ordonnance");
    
    setTitle("Add a new Ordonnance");
    setLayout(BoxLayout.y());
      medic.addActionListener(e-> new OrdonnanceMedicamentForm(this).show());
    btnValider.addActionListener(new ActionListener() {
        public void actionPerformed(ActionEvent evt) {
            if ((com.getText().length()==0)){
                         Dialog.show("Alert", "Please fill all the fields", new Command("OK"));
            }else{
                Ordonnance t = new Ordonnance(com.getText().toString());
            if (ServiceOrdonnance.getInstance().addOrdonnance(t,id)) {
                Dialog.show("Success", "Connection accepted", new Command("OK"));
                 ListOrdonnanceForm listOrdonnanceForm = new ListOrdonnanceForm(previous);
                    listOrdonnanceForm.show();
            } else {
                Dialog.show("ERROR", "Server error", new Command("OK"));
            }
            
            }
        }
    });
    
    addAll(com, medic, btnValider);
    getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
                
    
    }
    
}
