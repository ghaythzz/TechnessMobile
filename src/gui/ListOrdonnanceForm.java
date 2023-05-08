/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import com.codename1.components.SpanLabel;
import com.codename1.ui.Button;
import com.codename1.ui.Command;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.events.ActionListener;
import com.codename1.ui.layouts.BoxLayout;
import com.mycomany.entities.Ordonnance;
import com.mycompany.myapp.services.ServiceOrdonnance;
import java.util.ArrayList;


/**
 *
 * @author asus
 */
public class ListOrdonnanceForm extends Form {
    public ListOrdonnanceForm(Form previous){
     
        setTitle("Liste des ordonnances");
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
        ServiceOrdonnance es = new ServiceOrdonnance();

        ArrayList<Ordonnance> list = es.getAllOrdonnance();
         {
           
            for (Ordonnance o : list) {

          
 
                Container c3 = new Container(BoxLayout.y());
               
                 SpanLabel cat= new SpanLabel("Nom de l'medecin :" + o.getNomMedecin());
                 SpanLabel cat1= new SpanLabel("Nom de patient :" + o.getNomPatient());
                 SpanLabel cat2= new SpanLabel("date :" + o.getDate());
                 SpanLabel cat3= new SpanLabel("Commentaire :" + o.getCommentaire());
                 
               
                     
                      
                        c3.add(cat);
                        c3.add(cat1);
                        c3.add(cat2);
                        c3.add(cat3);
                        Button Delete =new Button("Delete");
                        Button update =new Button("update");
                        c3.add(Delete);
                        c3.add(update);
                        Delete.getAllStyles().setBgColor(0xF36B08);
                        Delete.addActionListener(e -> {
               Dialog alert = new Dialog("Attention");
                SpanLabel message = new SpanLabel("Etes-vous sur de vouloir supprimer cette ordonnance?\nCette action est irréversible!");
                alert.add(message);
                Button ok = new Button("Confirmer");
                Button cancel = new Button(new Command("Annuler"));
                //User clicks on ok to delete account
                ok.addActionListener(new ActionListener() {
                  
                    public void actionPerformed(ActionEvent evt) {
                       es.deleteOrdonnance(o.getId());
                     
                        alert.dispose();
                        refreshTheme();
                    }
                    
                }
                
                
                );

                alert.add(cancel);
                alert.add(ok);
                alert.showDialog();
                
                new ListOrdonnanceForm(previous).show();
              
                
             
            });
                        update.addActionListener(e -> new ModofierOrdonnanceForm(this,o).show());
                    
                
                        
                        add(c3);
              
            
          getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK
                , e-> previous.showBack()); // Revenir vers l'interface précédente
                
            }
         }
    }
}
