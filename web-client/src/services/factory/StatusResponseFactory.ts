import {StatusResponseData} from '@/objects/response/StatusResponseData';
import {Location} from '@/objects/entity/Location';
import {Ship} from '@/objects/entity/Ship';
import {provide} from 'inversify-binding-decorators';
import {Sector} from '@/objects/entity/Sector';
import {JumpNode} from '@/objects/entity/JumpNode';
import {Dockable} from '@/objects/entity/Dockable';

@provide(StatusResponseFactory)
export class StatusResponseFactory {
    public createStatusResponse(data: any): StatusResponseData {
        const ship = Ship.create(data.player.ship);

        const sectors: Sector[] = data.system.sectors.map((x: any): Sector => {
            return new Sector(x.type, Location.create(x.location));
        });

        const jumpNodes: JumpNode[] = data.system.entryNodes.map((x: any): JumpNode => {
            const jumpNode = new JumpNode(x.id, Location.create(x.location));

            if (x.exitLocation) {
                jumpNode.exitLocation = Location.create(x.exitLocation);
            }

            return jumpNode;
        });

        const dockables: Dockable[] = data.system.dockables.map((x: any): Dockable => {
            return Dockable.create(x);
        });

        return new StatusResponseData(ship, sectors, jumpNodes, dockables);
    }
}
